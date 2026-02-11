<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query()->pluck('id');
        if ($users->isEmpty()) {
            $this->command?->warn('Нет пользователей для создания клиентов. Сначала создайте пользователей.');
            return;
        }

        $now = now();
        $clients = [
            [
                'name' => 'ООО "ТехноСервис"',
                'contact_person' => 'Иванов Иван Иванович',
                'email' => 'ivanov@technoservice.ru',
                'phone' => '+7 (495) 123-45-67',
                'type' => 'company',
                'address' => 'г. Москва, ул. Ленина, д. 10, офис 205',
                'status' => 'active',
                'notes' => 'Корпоративный клиент с 2019 года. Требуется ежемесячный отчет по трафику. Оплата по безналичному расчету.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ЗАО "ИнфоТех"',
                'contact_person' => 'Петрова Мария Сергеевна',
                'email' => 'petrova@infotech.ru',
                'phone' => '+7 (495) 234-56-78',
                'type' => 'company',
                'address' => 'г. Москва, пр-т Мира, д. 25, стр. 1',
                'status' => 'active',
                'notes' => 'Активный клиент. Часто требуется техническая поддержка. Оплата по карте.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ООО "МедиаГрупп"',
                'contact_person' => 'Сидоров Алексей Владимирович',
                'email' => 'sidorov@mediagroup.ru',
                'phone' => '+7 (495) 345-67-89',
                'type' => 'company',
                'address' => 'г. Москва, ул. Тверская, д. 15, офис 501',
                'status' => 'active',
                'notes' => 'Медиа-компания. Высокие требования к скорости и стабильности. Приоритетная поддержка.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ИП Козлов Дмитрий Николаевич',
                'contact_person' => 'Козлов Дмитрий Николаевич',
                'email' => 'kozlov@mail.ru',
                'phone' => '+7 (495) 456-78-90',
                'type' => 'person',
                'address' => 'г. Москва, ул. Садовая, д. 8, кв. 42',
                'status' => 'active',
                'notes' => 'Индивидуальный предприниматель. Работает с 2020 года. Оплата наличными.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ООО "СтройМастер"',
                'contact_person' => 'Федорова Елена Викторовна',
                'email' => 'fedorova@stroimaster.ru',
                'phone' => '+7 (495) 567-89-01',
                'type' => 'company',
                'address' => 'г. Москва, ул. Строителей, д. 30',
                'status' => 'active',
                'notes' => 'Строительная компания. Требуется стабильное подключение для работы с проектной документацией.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ООО "Торговый Дом"',
                'contact_person' => 'Морозов Сергей Алексеевич',
                'email' => 'morozov@torgdom.ru',
                'phone' => '+7 (495) 678-90-12',
                'type' => 'company',
                'address' => 'г. Москва, ул. Торговая, д. 5',
                'status' => 'inactive',
                'notes' => 'Клиент временно приостановил использование услуг. Договор не расторгнут. Требуется связь с клиентом.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ООО "АвтоПром"',
                'contact_person' => 'Николаев Андрей Петрович',
                'email' => 'nikolaev@avtoprom.ru',
                'phone' => '+7 (495) 789-01-23',
                'type' => 'company',
                'address' => 'г. Москва, ул. Автомобильная, д. 20',
                'status' => 'active',
                'notes' => 'Автомобильная компания. Высокие требования к безопасности соединения. Корпоративный VPN.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ООО "БизнесКонсалт"',
                'contact_person' => 'Волкова Ольга Дмитриевна',
                'email' => 'volkova@bizconsult.ru',
                'phone' => '+7 (495) 890-12-34',
                'type' => 'company',
                'address' => 'г. Москва, ул. Деловая, д. 12, офис 301',
                'status' => 'blocked',
                'notes' => 'Клиент заблокирован из-за задолженности за 3 месяца. Требуется погашение долга для восстановления услуг.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ООО "ЭкоСистемы"',
                'contact_person' => 'Соколов Павел Игоревич',
                'email' => 'sokolov@ecosystems.ru',
                'phone' => '+7 (495) 901-23-45',
                'type' => 'company',
                'address' => 'г. Москва, ул. Экологическая, д. 7',
                'status' => 'active',
                'notes' => 'Экологическая компания. Работает с удаленными офисами. Требуется стабильное соединение.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ООО "ЛогистикПро"',
                'contact_person' => 'Лебедева Анна Александровна',
                'email' => 'lebedeva@logisticpro.ru',
                'phone' => '+7 (495) 012-34-56',
                'type' => 'company',
                'address' => 'г. Москва, ул. Логистическая, д. 33',
                'status' => 'active',
                'notes' => 'Логистическая компания. Работает 24/7. Критически важна стабильность связи. Приоритетная поддержка.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ООО "ФинансКонсалт"',
                'contact_person' => 'Кузнецов Игорь Сергеевич',
                'email' => 'kuznetsov@finconsult.ru',
                'phone' => '+7 (495) 123-45-78',
                'type' => 'company',
                'address' => 'г. Москва, ул. Финансовая, д. 18, офис 401',
                'status' => 'active',
                'notes' => 'Финансовая компания. Высокие требования к безопасности. Шифрование трафика. Дополнительные услуги безопасности.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ООО "Образование+"',
                'contact_person' => 'Новикова Татьяна Владимировна',
                'email' => 'novikova@educationplus.ru',
                'phone' => '+7 (495) 234-56-89',
                'type' => 'company',
                'address' => 'г. Москва, ул. Образовательная, д. 22',
                'status' => 'active',
                'notes' => 'Образовательное учреждение. Работает с онлайн-платформами. Требуется высокая скорость для видеоконференций.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ООО "РекламаАгент"',
                'contact_person' => 'Максимов Роман Олегович',
                'email' => 'maksimov@reklamagent.ru',
                'phone' => '+7 (495) 345-67-90',
                'type' => 'company',
                'address' => 'г. Москва, ул. Рекламная, д. 11',
                'status' => 'inactive',
                'notes' => 'Клиент временно приостановил услуги. Переехал в другой офис. Требуется перенос подключения.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ООО "ТранспортСервис"',
                'contact_person' => 'Орлов Владимир Николаевич',
                'email' => 'orlov@transservice.ru',
                'phone' => '+7 (495) 456-78-01',
                'type' => 'company',
                'address' => 'г. Москва, ул. Транспортная, д. 40',
                'status' => 'active',
                'notes' => 'Транспортная компания. Работает с системой мониторинга транспорта. Требуется стабильное соединение.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ООО "МедиаСтудия"',
                'contact_person' => 'Петрова Светлана Ивановна',
                'email' => 'petrova@media-studio.ru',
                'phone' => '+7 (495) 567-89-12',
                'type' => 'company',
                'address' => 'г. Москва, ул. Студийная, д. 14',
                'status' => 'blocked',
                'notes' => 'Клиент заблокирован. Нарушение условий договора. Использование трафика для незаконной деятельности. Требуется расследование.',
                'user_id' => $users->random(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('provider_clients')->insert($clients);
    }
}
