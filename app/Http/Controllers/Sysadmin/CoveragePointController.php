<?php
// app/Http/Controllers/Sysadmin/CoveragePointController.php

namespace App\Http\Controllers\Sysadmin;

use App\Http\Controllers\Controller;
use App\Models\NetworkMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CoveragePointController extends Controller
{
    public function index()
    {
        try {
            $points = NetworkMap::all(); // Просто получаем все точки без связи

            $points = $points->map(function ($point) {
                return [
                    'id' => $point->id,
                    'name' => $point->name,
                    'latitude' => (float) $point->latitude,
                    'longitude' => (float) $point->longitude,
                    'is_available' => (bool) $point->is_available,
                    'address' => $point->address,
                    'coverage_radius' => (float) ($point->coverage_radius ?? 5),
                    'technical_info' => $point->technical_info,
                    'capacity' => $point->capacity,
                    'current_load' => $point->current_load ?? 0,
                    // Эти поля можно пока оставить заглушками или убрать
                    'equipment_count' => 0,
                    'active_connections' => $point->current_load ?? 0,
                    'load' => $point->capacity ? round(($point->current_load / $point->capacity) * 100, 1) : 0,
                    'equipment' => [] // Пустой массив для оборудования
                ];
            });

            return response()->json($points);
        } catch (\Exception $e) {
            Log::error('Ошибка загрузки точек покрытия: ' . $e->getMessage());
            return response()->json(['error' => 'Ошибка загрузки данных'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'coverage_radius' => 'required|numeric|min:0.1',
                'address' => 'nullable|string',
                'technical_info' => 'nullable|string',
                'capacity' => 'nullable|integer|min:1',
                'current_load' => 'nullable|integer|min:0',
                'is_available' => 'boolean'
            ]);

            $point = NetworkMap::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Точка покрытия успешно создана',
                'data' => $point
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Ошибка создания точки покрытия: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании точки: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $point = NetworkMap::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'latitude' => 'sometimes|numeric',
                'longitude' => 'sometimes|numeric',
                'coverage_radius' => 'sometimes|numeric|min:0.1',
                'address' => 'nullable|string',
                'technical_info' => 'nullable|string',
                'capacity' => 'nullable|integer|min:1',
                'current_load' => 'nullable|integer|min:0',
                'is_available' => 'boolean'
            ]);

            $point->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Точка покрытия успешно обновлена',
                'data' => $point
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Ошибка обновления точки покрытия: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении точки: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $point = NetworkMap::findOrFail($id);
            $point->delete();

            return response()->json([
                'success' => true,
                'message' => 'Точка покрытия успешно удалена'
            ]);

        } catch (\Exception $e) {
            Log::error('Ошибка удаления точки покрытия: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении точки: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkByAddress(Request $request)
    {
        try {
            $address = $request->input('address');

            if (empty($address)) {
                return response()->json([
                    'available' => false,
                    'error' => true,
                    'message' => 'Адрес не указан'
                ]);
            }

            $apiKey = config('services.yandex_maps.api_key');

            if (!$apiKey) {
                Log::warning('Yandex Maps API ключ не настроен');
                return response()->json([
                    'available' => false,
                    'error' => true,
                    'message' => 'Сервис геокодирования временно недоступен'
                ]);
            }

            $response = Http::get('https://geocode-maps.yandex.ru/v1/', [
                'apikey' => $apiKey,
                'geocode' => $address,
                'format' => 'json',
                'results' => 1
            ]);

            if (!$response->successful()) {
                Log::error('Ошибка Яндекс геокодера: ' . $response->body());
                return response()->json([
                    'available' => false,
                    'error' => true,
                    'message' => 'Не удалось определить координаты адреса'
                ]);
            }

            $data = $response->json();

            if (empty($data['response']['GeoObjectCollection']['featureMember'])) {
                return response()->json([
                    'available' => false,
                    'error' => true,
                    'message' => 'Адрес не найден'
                ]);
            }

            $pos = explode(' ', $data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']);
            $longitude = (float) $pos[0];
            $latitude = (float) $pos[1];

            // Поиск ближайшей точки покрытия
            $points = NetworkMap::where('is_available', true)->get();

            if ($points->isEmpty()) {
                return response()->json([
                    'available' => false,
                    'nearest_node' => null,
                    'distance_km' => null,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'message' => 'Нет доступных точек покрытия'
                ]);
            }

            $nearestNode = null;
            $minDistance = INF;

            foreach ($points as $point) {
                $distance = $this->calculateDistance(
                    $latitude, $longitude,
                    $point->latitude, $point->longitude
                );

                if ($distance < $minDistance) {
                    $minDistance = $distance;
                    $nearestNode = $point;
                }
            }

            $available = $nearestNode && $minDistance <= ($nearestNode->coverage_radius ?? 5);

            return response()->json([
                'available' => $available,
                'nearest_node' => $nearestNode ? [
                    'id' => $nearestNode->id,
                    'name' => $nearestNode->name,
                    'latitude' => $nearestNode->latitude,
                    'longitude' => $nearestNode->longitude,
                    'coverage_radius' => $nearestNode->coverage_radius
                ] : null,
                'distance_km' => round($minDistance, 2),
                'latitude' => $latitude,
                'longitude' => $longitude,
                'message' => $available ? 'Покрытие доступно' : 'Покрытие недоступно'
            ]);

        } catch (\Exception $e) {
            Log::error('Ошибка проверки адреса: ' . $e->getMessage());
            return response()->json([
                'available' => false,
                'error' => true,
                'message' => 'Ошибка при проверке адреса'
            ], 500);
        }
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos($lat1) * cos($lat2) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
