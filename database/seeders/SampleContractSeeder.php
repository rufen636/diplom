<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SampleContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Очистка таблицы перед заполнением (опционально)
        // DB::table('sample_contracts')->truncate();

        // Шаблон для физических лиц (активный)
        DB::table('sample_contracts')->insert([
            'template_code' => 'TEMP-INDIVIDUAL-2024',
            'name' => 'Шаблон для физических лиц 2024',
            'description' => 'Базовый шаблон договора для физических лиц',
            'contract_type' => 'individual',
            'status' => 'active',
            'version' => '2.1',
            'is_default' => true,
            'sections' => json_encode($this->getIndividualSections()),
            'metadata' => json_encode([
                'variables' => ['client_name', 'client_address', 'client_passport', 'tariff_name', 'tariff_speed', 'tariff_price'],
                'styles' => [
                    'font_family' => 'Arial',
                    'font_size' => 12,
                    'line_spacing' => 1.5
                ]
            ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Шаблон для юридических лиц (активный)
        DB::table('sample_contracts')->insert([
            'template_code' => 'TEMP-COMPANY-2024',
            'name' => 'Шаблон для юридических лиц 2024',
            'description' => 'Базовый шаблон договора для юридических лиц',
            'contract_type' => 'company',
            'status' => 'active',
            'version' => '3.0',
            'is_default' => true,
            'sections' => json_encode($this->getCompanySections()),
            'metadata' => json_encode([
                'variables' => ['company_name', 'legal_address', 'inn', 'kpp', 'bank_details', 'tariff_name', 'tariff_speed', 'tariff_price'],
                'styles' => [
                    'font_family' => 'Arial',
                    'font_size' => 12,
                    'line_spacing' => 1.5
                ]
            ]),
            'notes' => 'Базовый шаблон для юридических лиц. Используется по умолчанию.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Шаблон в черновике
        DB::table('sample_contracts')->insert([
            'template_code' => 'TEMP-INDIVIDUAL-DRAFT-2025',
            'name' => 'Новый шаблон для физлиц (в разработке)',
            'description' => 'Экспериментальный шаблон с новыми условиями',
            'contract_type' => 'individual',
            'status' => 'draft',
            'version' => '0.9',
            'is_default' => false,
            'sections' => json_encode($this->getDraftSections()),
            'metadata' => json_encode([
                'variables' => ['client_name', 'client_address', 'tariff_name', 'tariff_price'],
                'styles' => ['font_family' => 'Arial', 'font_size' => 12]
            ]),
            'notes' => 'Экспериментальный шаблон. В разработке, не использовать в продакшене.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Архивный шаблон
        DB::table('sample_contracts')->insert([
            'template_code' => 'TEMP-COMPANY-ARCHIVE-2023',
            'name' => 'Шаблон для юрлиц 2023 (архивный)',
            'description' => 'Устаревший шаблон, не рекомендуется к использованию',
            'contract_type' => 'company',
            'status' => 'archived',
            'version' => '2.0',
            'is_default' => false,
            'sections' => json_encode($this->getArchiveSections()),
            'metadata' => json_encode([
                'variables' => ['company_name', 'legal_address'],
                'styles' => ['font_family' => 'Arial', 'font_size' => 12]
            ]),
            'notes' => 'Устаревший шаблон. Для новых договоров не использовать.',
            'created_at' => Carbon::now()->subYear(),
            'updated_at' => Carbon::now()->subMonths(6),
        ]);
    }

    /**
     * Структура разделов для физических лиц
     */
    private function getIndividualSections(): array
    {
        return [
            [
                'id' => 'sec_1',
                'title' => 'ПРЕАМБУЛА',
                'order' => 1,
                'items' => [
                    [
                        'id' => 'item_1_1',
                        'number' => null,
                        'title' => null,
                        'content' => 'г. Минск "___" _________ 20__ г.

{{client_name}}, именуем__ в дальнейшем "Заказчик", с одной стороны, и ООО "Интернет-Провайдер", именуемое в дальнейшем "Исполнитель", с другой стороны, совместно именуемые "Стороны", заключили настоящий Договор о нижеследующем:',
                        'order' => 1,
                        'type' => 'text',
                        'children' => []
                    ]
                ]
            ],
            [
                'id' => 'sec_2',
                'title' => '1. ПРЕДМЕТ ДОГОВОРА',
                'order' => 2,
                'items' => [
                    [
                        'id' => 'item_2_1',
                        'number' => '1.1.',
                        'title' => null,
                        'content' => 'Исполнитель обязуется предоставить Заказчику доступ к сети Интернет по адресу: {{client_address}}.',
                        'order' => 1,
                        'type' => 'clause',
                        'children' => [
                            [
                                'id' => 'item_2_1_1',
                                'number' => '1.1.1.',
                                'title' => null,
                                'content' => 'Скорость подключения: {{tariff_speed}} Мбит/с.',
                                'order' => 1,
                                'type' => 'subclause',
                                'children' => []
                            ],
                            [
                                'id' => 'item_2_1_2',
                                'number' => '1.1.2.',
                                'title' => null,
                                'content' => 'Абонентская плата: {{tariff_price}} руб.',
                                'order' => 2,
                                'type' => 'subclause',
                                'children' => []
                            ]
                        ]
                    ],
                    [
                        'id' => 'item_2_2',
                        'number' => '1.2.',
                        'title' => null,
                        'content' => 'Срок оказания услуг: с даты подписания Договора до момента расторжения.',
                        'order' => 2,
                        'type' => 'clause',
                        'children' => []
                    ]
                ]
            ],
            [
                'id' => 'sec_3',
                'title' => '2. ПРАВА И ОБЯЗАННОСТИ СТОРОН',
                'order' => 3,
                'items' => [
                    [
                        'id' => 'item_3_1',
                        'number' => null,
                        'title' => '2.1. Исполнитель обязуется:',
                        'content' => "Обеспечить круглосуточный доступ к сети Интернет\nУстранять аварии в минимальные сроки\nИнформировать о плановых работах",
                        'order' => 1,
                        'type' => 'list',
                        'children' => []
                    ],
                    [
                        'id' => 'item_3_2',
                        'number' => null,
                        'title' => '2.2. Заказчик обязуется:',
                        'content' => "Своевременно оплачивать услуги\nНе нарушать правила пользования сетью\nСообщать об изменениях персональных данных",
                        'order' => 2,
                        'type' => 'list',
                        'children' => []
                    ]
                ]
            ],
            [
                'id' => 'sec_4',
                'title' => '3. ПОРЯДОК РАСЧЕТОВ',
                'order' => 4,
                'items' => [
                    [
                        'id' => 'item_4_1',
                        'number' => '3.1.',
                        'title' => null,
                        'content' => 'Абонентская плата вносится ежемесячно до 25-го числа текущего месяца.',
                        'order' => 1,
                        'type' => 'clause',
                        'children' => []
                    ],
                    [
                        'id' => 'item_4_2',
                        'number' => '3.2.',
                        'title' => null,
                        'content' => 'Оплата производится наличными в кассу или через систему интернет-банкинга.',
                        'order' => 2,
                        'type' => 'clause',
                        'children' => []
                    ]
                ]
            ],
            [
                'id' => 'sec_5',
                'title' => '4. ОТВЕТСТВЕННОСТЬ СТОРОН',
                'order' => 5,
                'items' => [
                    [
                        'id' => 'item_5_1',
                        'number' => '4.1.',
                        'title' => null,
                        'content' => 'За нарушение сроков оплаты Заказчик уплачивает пеню в размере 0,1% от суммы задолженности за каждый день просрочки.',
                        'order' => 1,
                        'type' => 'clause',
                        'children' => []
                    ]
                ]
            ],
            [
                'id' => 'sec_6',
                'title' => '5. ФОРС-МАЖОР',
                'order' => 6,
                'items' => [
                    [
                        'id' => 'item_6_1',
                        'number' => null,
                        'title' => null,
                        'content' => 'Стороны освобождаются от ответственности за неисполнение обязательств, если оно вызвано обстоятельствами непреодолимой силы.',
                        'order' => 1,
                        'type' => 'text',
                        'children' => []
                    ]
                ]
            ],
            [
                'id' => 'sec_7',
                'title' => '6. РАЗРЕШЕНИЕ СПОРОВ',
                'order' => 7,
                'items' => [
                    [
                        'id' => 'item_7_1',
                        'number' => null,
                        'title' => null,
                        'content' => 'Все споры решаются путем переговоров. При недостижении согласия – в суде по месту нахождения Исполнителя.',
                        'order' => 1,
                        'type' => 'text',
                        'children' => []
                    ]
                ]
            ]
        ];
    }

    /**
     * Структура разделов для юридических лиц
     */
    private function getCompanySections(): array
    {
        return [
            [
                'id' => 'sec_1',
                'title' => 'ПРЕАМБУЛА',
                'order' => 1,
                'items' => [
                    [
                        'id' => 'item_1_1',
                        'number' => null,
                        'title' => null,
                        'content' => 'г. Минск "___" _________ 20__ г.

{{company_name}}, в лице __________________, действующ__ на основании __________________, именуем__ в дальнейшем "Заказчик", с одной стороны, и ООО "Интернет-Провайдер", в лице Генерального директора Иванова И.И., действующего на основании Устава, именуемое в дальнейшем "Исполнитель", с другой стороны, заключили настоящий Договор.',
                        'order' => 1,
                        'type' => 'text',
                        'children' => []
                    ]
                ]
            ],
            [
                'id' => 'sec_2',
                'title' => '1. ПРЕДМЕТ ДОГОВОРА',
                'order' => 2,
                'items' => [
                    [
                        'id' => 'item_2_1',
                        'number' => '1.1.',
                        'title' => null,
                        'content' => 'Исполнитель обязуется предоставить Заказчику услуги доступа к сети Интернет.',
                        'order' => 1,
                        'type' => 'clause',
                        'children' => [
                            [
                                'id' => 'item_2_1_1',
                                'number' => '1.1.1.',
                                'title' => null,
                                'content' => 'Адрес подключения: {{legal_address}}',
                                'order' => 1,
                                'type' => 'subclause',
                                'children' => []
                            ],
                            [
                                'id' => 'item_2_1_2',
                                'number' => '1.1.2.',
                                'title' => null,
                                'content' => 'Тариф: {{tariff_name}} (скорость {{tariff_speed}} Мбит/с)',
                                'order' => 2,
                                'type' => 'subclause',
                                'children' => []
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Структура разделов для черновика
     */
    private function getDraftSections(): array
    {
        return [
            [
                'id' => 'sec_1',
                'title' => 'Черновик - в разработке',
                'order' => 1,
                'items' => [
                    [
                        'id' => 'item_1_1',
                        'number' => null,
                        'title' => null,
                        'content' => 'Шаблон находится в стадии разработки. Содержание будет дополнено.',
                        'order' => 1,
                        'type' => 'text',
                        'children' => []
                    ]
                ]
            ]
        ];
    }

    /**
     * Структура разделов для архивного шаблона
     */
    private function getArchiveSections(): array
    {
        return [
            [
                'id' => 'sec_1',
                'title' => 'ПРЕАМБУЛА (Архивный шаблон)',
                'order' => 1,
                'items' => [
                    [
                        'id' => 'item_1_1',
                        'number' => null,
                        'title' => null,
                        'content' => 'Данный шаблон является устаревшим и не рекомендуется к использованию.',
                        'order' => 1,
                        'type' => 'text',
                        'children' => []
                    ]
                ]
            ],
            [
                'id' => 'sec_2',
                'title' => '1. ПРЕДМЕТ ДОГОВОРА',
                'order' => 2,
                'items' => [
                    [
                        'id' => 'item_2_1',
                        'number' => '1.1.',
                        'title' => null,
                        'content' => 'Исполнитель оказывает услуги по подключению к сети Интернет.',
                        'order' => 1,
                        'type' => 'clause',
                        'children' => []
                    ]
                ]
            ]
        ];
    }
}
