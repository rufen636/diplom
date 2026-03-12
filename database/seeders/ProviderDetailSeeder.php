<?php

namespace Database\Seeders;

use App\Models\ProviderClient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = ProviderClient::all();

        if ($clients->isEmpty()) {
            $this->command?->warn('Нет клиентов для создания деталей. Сначала запустите ProviderClientSeeder.');
            return;
        }

        $now = now();
        $details = [];

        foreach ($clients as $index => $client) {
            // Генерируем детали для каждого клиента
            $details[] = $this->generateDetailsForClient($client, $index, $now);
        }

        DB::table('provider_details')->insert($details);

        $this->command?->info('Детали клиентов успешно добавлены.');
    }

    /**
     * Generate details for a specific client
     */
    private function generateDetailsForClient($client, int $index, $now): array
    {
        // Базовые детали для всех клиентов
        $baseDetails = [
            'full_name' => $client->contact_person ?? $client->name,
            'legal_address' => $client->address ?? 'г. Москва, ул. Примерная, д. ' . ($index + 1),
            'actual_address' => $client->address ?? null,
            'phone' => $client->phone,
            'email' => $client->email,
            'provider_client_id' => $client->id,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // Добавляем дополнительные детали в зависимости от типа клиента
        if ($client->type === 'company') {
            return array_merge($baseDetails, $this->getCompanyDetails($client, $index));
        } else {
            return array_merge($baseDetails, $this->getPersonDetails($client, $index));
        }
    }

    /**
     * Get details for company type client
     */
    private function getCompanyDetails($client, int $index): array
    {
        $bankDetails = [
            'ООО "ТехноСервис"' => 'р/с 40702810123450000123 в ПАО Сбербанк, БИК 044525225, к/с 30101810400000000225',
            'ЗАО "ИнфоТех"' => 'р/с 40702810567890000456 в АО "Альфа-Банк", БИК 044525593, к/с 30101810200000000593',
            'ООО "МедиаГрупп"' => 'р/с 40702810789010000789 в ПАО ВТБ, БИК 044525187, к/с 30101810300000000187',
            'ООО "СтройМастер"' => 'р/с 40702810234560000987 в ПАО "Промсвязьбанк", БИК 044525555, к/с 30101810400000000555',
            'ООО "Торговый Дом"' => 'р/с 40702810987650000555 в АО "Райффайзенбанк", БИК 044525700, к/с 30101810200000000700',
            'ООО "АвтоПром"' => 'р/с 40702810321000001111 в ПАО "Московский кредитный банк", БИК 044525659, к/с 30101810700000000659',
            'ООО "БизнесКонсалт"' => 'р/с 40702810654320002222 в ПАО "Банк Уралсиб", БИК 044525788, к/с 30101810400000000788',
            'ООО "ЭкоСистемы"' => 'р/с 40702810987650003333 в АО "Россельхозбанк", БИК 044525123, к/с 30101810500000000123',
            'ООО "ЛогистикПро"' => 'р/с 40702810234560004444 в ПАО "Совкомбанк", БИК 044525456, к/с 30101810900000000456',
            'ООО "ФинансКонсалт"' => 'р/с 40702810789010005555 в ПАО "Банк Санкт-Петербург", БИК 044525789, к/с 30101810800000000789',
            'ООО "Образование+"' => 'р/с 40702810567890006666 в ПАО "Ак Барс" Банк, БИК 044525987, к/с 30101810600000000987',
            'ООО "РекламаАгент"' => 'р/с 40702810321000007777 в АО "Тинькофф Банк", БИК 044525974, к/с 30101810100000000974',
            'ООО "ТранспортСервис"' => 'р/с 40702810654320008888 в ПАО "МТС-Банк", БИК 044525765, к/с 30101810400000000765',
            'ООО "МедиаСтудия"' => 'р/с 40702810987650009999 в ПАО "Почта Банк", БИК 044525321, к/с 30101810500000000321',
        ];

        $websites = [
            'ООО "ТехноСервис"' => 'https://www.technoservice.ru',
            'ЗАО "ИнфоТех"' => 'https://www.infotech.ru',
            'ООО "МедиаГрупп"' => 'https://www.mediagroup.ru',
            'ООО "СтройМастер"' => 'https://www.stroimaster.ru',
            'ООО "Торговый Дом"' => 'https://www.torgdom.ru',
            'ООО "АвтоПром"' => 'https://www.avtoprom.ru',
            'ООО "БизнесКонсалт"' => 'https://www.bizconsult.ru',
            'ООО "ЭкоСистемы"' => 'https://www.ecosystems.ru',
            'ООО "ЛогистикПро"' => 'https://www.logisticpro.ru',
            'ООО "ФинансКонсалт"' => 'https://www.finconsult.ru',
            'ООО "Образование+"' => 'https://www.educationplus.ru',
            'ООО "РекламаАгент"' => 'https://www.reklamagent.ru',
            'ООО "ТранспортСервис"' => 'https://www.transservice.ru',
            'ООО "МедиаСтудия"' => 'https://www.media-studio.ru',
        ];

        return [
            'bank_details' => $bankDetails[$client->name] ?? 'р/с 40702810123450000' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) . ' в ПАО "Банк", БИК 044525225, к/с 30101810400000000225',
            'website' => $websites[$client->name] ?? 'https://www.company' . ($index + 1) . '.ru',
        ];
    }

    /**
     * Get details for person type client
     */
    private function getPersonDetails($client, int $index): array
    {
        // Для ИП используем другие данные
        if (str_contains($client->name, 'ИП')) {
            return [
                'bank_details' => 'р/с 40802810789010000' . ($index + 1) . ' в ПАО Сбербанк, БИК 044525225, к/с 30101810400000000225',
                'website' => null, // У ИП обычно нет сайта
            ];
        }

        return [
            'bank_details' => null,
            'website' => null,
        ];
    }
}
