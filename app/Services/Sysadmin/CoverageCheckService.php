<?php

namespace App\Services\Sysadmin;

use App\Models\NetworkMap;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CoverageCheckService
{
    // Радиус покрытия узла в километрах
    const DEFAULT_COVERAGE_RADIUS = 10;

    // API для геокодинга (можно заменить на DaData, Google Maps и т.д.)
    const GEOCODING_API = 'https://nominatim.openstreetmap.org/search';

    /**
     * Проверка доступности ресурсов по адресу
     */
    public function checkByAddress(string $address): array
    {
        try {
            // 1. Геокодинг адреса
            $coordinates = $this->geocodeAddress($address);

            if (!$coordinates) {
                return [
                    'success' => false,
                    'available' => false,
                    'error' => 'Не удалось определить координаты адреса',
                    'message' => 'Пожалуйста, уточните адрес или введите координаты вручную'
                ];
            }

            // 2. Поиск ближайшего узла сети
            $nearestNode = $this->findNearestNode(
                $coordinates['lat'],
                $coordinates['lon']
            );

            if (!$nearestNode) {
                return [
                    'success' => false,
                    'available' => false,
                    'error' => 'В данном районе нет узлов сети',
                    'message' => 'Подключение временно недоступно. Ведутся работы по расширению сети.'
                ];
            }

            // 3. Проверка доступности оборудования в узле
            $availableEquipment = $this->checkAvailableEquipment($nearestNode);

            // 4. Расчет расстояния
            $distance = $this->calculateDistance(
                $coordinates['lat'],
                $coordinates['lon'],
                $nearestNode->latitude,
                $nearestNode->longitude
            );

            // 5. Проверка входит ли адрес в зону покрытия
            $inCoverageZone = $distance <= ($nearestNode->coverage_radius ?? self::DEFAULT_COVERAGE_RADIUS);

            // 6. Формирование результата
            $result = [
                'success' => true,
                'available' => $inCoverageZone && $availableEquipment['available'],
                'address' => $address,
                'coordinates' => $coordinates,
                'nearest_node' => [
                    'id' => $nearestNode->id,
                    'name' => $nearestNode->name,
                    'latitude' => $nearestNode->latitude,
                    'longitude' => $nearestNode->longitude,
                    'address' => $nearestNode->address ?? 'Адрес не указан',
                    'is_available' => $nearestNode->is_available,
                    'coverage_radius' => $nearestNode->coverage_radius ?? self::DEFAULT_COVERAGE_RADIUS,
                ],
                'distance_km' => round($distance, 2),
                'in_coverage_zone' => $inCoverageZone,
                'available_equipment' => $availableEquipment,
                'message' => $this->generateResultMessage($inCoverageZone, $availableEquipment, $distance)
            ];

            // Логируем успешную проверку
            Log::info('Coverage check completed', [
                'address' => $address,
                'node' => $nearestNode->name,
                'distance' => $distance,
                'available' => $result['available']
            ]);

            return $result;

        } catch (\Exception $e) {
            Log::error('Coverage check failed', [
                'address' => $address,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'available' => false,
                'error' => 'Ошибка при проверке адреса',
                'message' => 'Произошла техническая ошибка. Пожалуйста, попробуйте позже.'
            ];
        }
    }

    /**
     * Геокодинг адреса через OpenStreetMap Nominatim
     */
    private function geocodeAddress(string $address): ?array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => config('app.name') . ' - Coverage Check',
                'Accept' => 'application/json',
            ])->get(self::GEOCODING_API, [
                'q' => $address,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1,
            ]);

            if ($response->successful() && count($response->json()) > 0) {
                $data = $response->json()[0];
                return [
                    'lat' => (float) $data['lat'],
                    'lon' => (float) $data['lon'],
                    'display_name' => $data['display_name'],
                ];
            }
        } catch (\Exception $e) {
            Log::error('Geocoding failed', ['address' => $address, 'error' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * Поиск ближайшего узла сети
     */
    private function findNearestNode(float $lat, float $lon): ?NetworkMap
    {
        $nodes = NetworkMap::where('is_available', true)->get();

        if ($nodes->isEmpty()) {
            return null;
        }

        $nearestNode = null;
        $minDistance = PHP_FLOAT_MAX;

        foreach ($nodes as $node) {
            $distance = $this->calculateDistance($lat, $lon, $node->latitude, $node->longitude);

            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearestNode = $node;
            }
        }

        return $nearestNode;
    }

    /**
     * Расчет расстояния по формуле гаверсинуса
     */
    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // км

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Проверка доступности (оборудование — справочник типов, не привязан к узлам)
     */
    private function checkAvailableEquipment(NetworkMap $node): array
    {
        // Оборудование — справочник, не привязано к узлам. Считаем доступным при наличии покрытия.
        return [
            'available' => true,
            'total' => 0,
            'available_count' => 0,
            'utilization' => 0
        ];
    }

    /**
     * Генерация понятного сообщения для пользователя
     */
    private function generateResultMessage(bool $inCoverageZone, array $equipment, float $distance): string
    {
        if (!$inCoverageZone) {
            return "Адрес находится вне зоны покрытия (ближайший узел в {$distance} км). " .
                "Ведутся работы по расширению сети.";
        }

        if (!$equipment['available']) {
            return "В зоне покрытия временно нет свободного оборудования. " .
                "Загрузка узла: {$equipment['utilization']}%";
        }

        return "Адрес в зоне покрытия. Доступно оборудования: {$equipment['available_count']} из {$equipment['total']}";
    }
}
