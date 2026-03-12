# Стратегический план реализации функционала системного администратора

## 1. Обзор

По BPMN-диаграмме «Клиентский отдел (технический)» функционал системного администратора включает:

| Шаг | Описание | Сущности |
|-----|----------|----------|
| 1 | Получена заявка | `ServiceRequest` (статус `on_inspection`) |
| 2 | Открыть интегрированную карту покрытия сети | `NetworkMap` (БД покрытия) |
| 3 | Проверить ресурсы по адресу | Адрес установки + зоны покрытия |
| 4 | Привязать к оборудованию и назначить услуг | `Equipment`, `Service`, `ServiceRequest` |
| 5 | Отправить автоуведомление менеджеру | `Mail` |

---

## 2. Текущее состояние

### 2.1 Стек (composer.json)
- **Backend:** Laravel 12, PHP 8.4
- **Frontend:** Inertia.js + Vue 3
- **Авторизация:** Laravel Sanctum, Spatie Permission
- **API:** L5-Swagger, Ziggy для маршрутов
- **Почта:** Symfony Mailgun

### 2.2 Модели
- `ServiceRequest` — заявки (client_id, service_id, installation_address, status)
- `NetworkMap` — узлы сети (name, latitude, longitude, is_available)
- `Equipment` — оборудование (name, mac_address, ip_address)
- `Service` — услуги (связь equipment через service_equipment)
- `ProviderClient` — клиенты
- **Нет:** связи Equipment → NetworkMap, ServiceRequest → equipment_id

### 2.3 Роутинг sysadmin
- Роуты в `routes/engineer.php` (префикс `sysadmin`, middleware `role:sysadmin`)
- Сейчас используются контроллеры менеджера — нужны отдельные контроллеры sysadmin

---

## 3. Стратегия реализации

### Фаза 1: Инфраструктура и маршрутизация

#### 1.1 Реорганизация роутов
- Переименовать/создать `routes/sysadmin.php` для ясности
- Подключить в `web.php` вместо engineer.php (если это sysadmin)
- Создать отдельные контроллеры: `App\Http\Controllers\Sysadmin\*`

#### 1.2 Layout для Sysadmin
- `resources/js/Layouts/Sysadmin/SysadminLayout.vue` по аналогии с ManagerLayout
- Сайдбар с пунктами: Dashboard, Заявки на проверке, Карта покрытия, Оборудование

---

### Фаза 2: Расширение моделей и БД

#### 2.1 Миграция: привязка Equipment к зоне покрытия
```php
// Добавить в equipment:
$table->foreignId('network_map_id')->nullable()->constrained('network_maps');
```

#### 2.2 Миграция: привязка ServiceRequest к оборудованию
```php
// Добавить в service_requests:
$table->foreignId('equipment_id')->nullable()->constrained('equipment');
$table->foreignId('assigned_by')->nullable()->constrained('users'); // sysadmin
$table->timestamp('assigned_at')->nullable();
```

#### 2.3 Расширение NetworkMap (опционально)
Для «проверки ресурсов по адресу» можно:
- **Вариант A:** добавить поле `address` или `coverage_radius_km` к `network_maps`
- **Вариант B:** создать таблицу `coverage_zones` (network_map_id, address_pattern, radius)
- **Вариант C:** проверять «в зоне покрытия» по расстоянию до ближайшего узла (Haversine) — требует геокодинга адреса

Рекомендация: начать с **варианта C** (расстояние до узла) — минимум изменений схемы.

---

### Фаза 3: Серверная логика (по аналогии с Manager)

#### 3.1 Структура (как у Manager)
```
app/
├── Http/
│   ├── Controllers/Sysadmin/
│   │   ├── DashboardController.php
│   │   ├── ServiceRequestController.php  # заявки на проверке
│   │   ├── NetworkMapController.php     # карта покрытия
│   │   └── EquipmentController.php      # привязка оборудования
│   ├── Resources/Sysadmin/
│   │   ├── ServiceRequest/
│   │   │   └── ServiceRequestResource.php
│   │   ├── NetworkMap/
│   │   │   └── NetworkMapResource.php
│   │   └── Equipment/
│   │       └── EquipmentResource.php
│   └── Requests/Sysadmin/
│       └── AssignEquipmentRequest.php
├── Services/Sysadmin/
│   ├── CoverageCheckService.php     # проверка ресурсов по адресу
│   └── ServiceRequestAssignmentService.php
├── Handlers/Sysadmin/
│   └── AssignEquipmentHandler.php
└── DTO/Sysadmin/
    └── AssignEquipmentDto.php
```

#### 3.2 Ключевые сервисы

**CoverageCheckService**
- Метод `checkByAddress(string $address): array`
- Геокодинг адреса → координаты (через внешний API или упрощённый ввод координат)
- Поиск ближайшего узла NetworkMap в радиусе N км
- Возврат: `['available' => bool, 'nearest_node' => NetworkMap, 'distance_km' => float]`

**ServiceRequestAssignmentService**
- Метод `assignEquipment(ServiceRequest $request, int $equipmentId): void`
- Обновление service_request.equipment_id, assigned_by, assigned_at
- Смена статуса на `accepted` (или отдельный статус `equipment_assigned`)
- Отправка Mail менеджеру (RequestAssignedToManager или аналогично RequestInspection)

#### 3.3 Mail: уведомление менеджеру
- Создать `App\Mail\RequestAssignedToManager`
- Шаблон `view.notif_assigned`
- Отправка при привязке оборудования и назначении услуг

---

### Фаза 4: Vue-страницы (по аналогии с Manager)

#### 4.1 Страницы
| Маршрут | Компонент | Описание |
|---------|-----------|----------|
| `sysadmin.dashboard` | `Sysadmin/Dashboard.vue` | Сводка: заявок на проверке, карта |
| `sysadmin.service-requests.index` | `Sysadmin/ServiceRequest/Index.vue` | Список заявок со статусом `on_inspection` |
| `sysadmin.service-requests.show` | `Sysadmin/ServiceRequest/Show.vue` | Детали заявки + проверка по адресу + привязка оборудования |
| `sysadmin.network-map.index` | `Sysadmin/NetworkMap/Index.vue` | Интегрированная карта покрытия (Leaflet/OpenLayers/Mapbox) |
| `sysadmin.equipment.index` | `Sysadmin/Equipment/Index.vue` | Список оборудования по узлам (опционально) |

#### 4.2 Карта покрытия
- Библиотека: **Leaflet** (легко) или **Mapbox GL JS**
- Отображение точек из `NetworkMap` (latitude, longitude)
- Клик по точке → информация об узле и связанном оборудовании
- Поиск по адресу → геокодинг → подсветка зоны/ближайшего узла

#### 4.3 Страница заявки (Show)
- Блок «Проверить ресурсы по адресу»:
  - Поле `installation_address` (readonly из заявки)
  - Кнопка «Проверить» → запрос к API `CoverageCheckService`
  - Результат: доступно/недоступно, ближайший узел
- Блок «Привязать к оборудованию»:
  - Выбор оборудования (фильтр по узлу после проверки)
  - Выбор услуги (если нужно уточнить)
  - Кнопка «Назначить»
- После назначения → статус меняется, уведомление менеджеру

---

### Фаза 5: API и маршруты

#### 5.1 Роуты sysadmin
```php
// routes/sysadmin.php
Route::group([
    'prefix' => 'sysadmin',
    'as' => 'sysadmin.',
    'middleware' => ['auth', 'verified', 'role:sysadmin']
], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/service-requests', ServiceRequestController::class)->only(['index', 'show', 'update']);
    Route::get('/network-map', [NetworkMapController::class, 'index'])->name('network-map.index');
    Route::post('/service-requests/{serviceRequest}/check-coverage', [ServiceRequestController::class, 'checkCoverage'])->name('service-requests.check-coverage');
    Route::post('/service-requests/{serviceRequest}/assign-equipment', [ServiceRequestController::class, 'assignEquipment'])->name('service-requests.assign-equipment');
});
```

#### 5.2 Ziggy
- Обновить `php artisan ziggy:generate` после добавления маршрутов

---

## 4. Порядок реализации (рекомендуемый)

| # | Этап | Оценка |
|---|------|--------|
| 1 | Миграции: equipment.network_map_id, service_requests.equipment_id, assigned_by, assigned_at | 1–2 ч |
| 2 | SysadminLayout.vue + Sysadmin/Dashboard.vue | 2–3 ч |
| 3 | Sysadmin\ServiceRequestController (index, show) + Resource + Index.vue, Show.vue | 3–4 ч |
| 4 | CoverageCheckService + check-coverage endpoint + UI в Show.vue | 2–3 ч |
| 5 | AssignEquipmentHandler + assign-equipment endpoint + UI в Show.vue | 2–3 ч |
| 6 | Mail RequestAssignedToManager + вызов в Handler | 1 ч |
| 7 | NetworkMapController + Index.vue с картой (Leaflet) | 3–4 ч |
| 8 | Тестирование, доработка навигации, статусов | 2–3 ч |

**Итого:** ~16–23 часа чистой разработки.

---

## 5. Важные замечания

1. **Геокодинг:** для проверки по адресу потребуется API (например, DaData, Nominatim, Google Geocoding). Можно начать с ручного ввода координат или mock-данных.
2. **Статусы заявки:** имеет смысл ввести `equipment_assigned` или использовать `accepted` после привязки — согласовать с бизнес-логикой.
3. **Права:** менеджер не должен менять equipment_id; sysadmin — только заявки в статусе `on_inspection`.
4. **Файл engineer.php:** сейчас содержит sysadmin-маршруты — лучше вынести в `sysadmin.php` для единообразия.

---

## 6. Связь с текущим потоком менеджера

```
Менеджер создаёт заявку → status = 'created'
Менеджер переводит в 'on_inspection' → отправка Mail sysadmin (уже есть в ServiceRequestHandler)
Sysadmin получает заявку → проверяет покрытие → привязывает оборудование → отправка Mail менеджеру
Менеджер получает уведомление → продолжает оформление договора
```

---

## 7. Файлы для создания/изменения (чек-лист)

### Создать
- [ ] `database/migrations/xxxx_add_equipment_to_service_requests.php`
- [ ] `database/migrations/xxxx_add_network_map_to_equipment.php`
- [ ] `app/Http/Controllers/Sysadmin/DashboardController.php`
- [ ] `app/Http/Controllers/Sysadmin/ServiceRequestController.php`
- [ ] `app/Http/Controllers/Sysadmin/NetworkMapController.php`
- [ ] `app/Services/Sysadmin/CoverageCheckService.php`
- [ ] `app/Services/Sysadmin/ServiceRequestAssignmentService.php`
- [ ] `app/Handlers/Sysadmin/AssignEquipmentHandler.php`
- [ ] `app/Mail/RequestAssignedToManager.php`
- [ ] `resources/views/view/notif_assigned.blade.php`
- [ ] `resources/js/Layouts/Sysadmin/SysadminLayout.vue`
- [ ] `resources/js/Pages/Sysadmin/Dashboard.vue`
- [ ] `resources/js/Pages/Sysadmin/ServiceRequest/Index.vue`
- [ ] `resources/js/Pages/Sysadmin/ServiceRequest/Show.vue`
- [ ] `resources/js/Pages/Sysadmin/NetworkMap/Index.vue`
- [ ] `routes/sysadmin.php` (или переименовать engineer.php)

### Изменить
- [ ] `routes/web.php` — подключить sysadmin.php
- [ ] `app/Models/ServiceRequest.php` — связи equipment(), assignedBy()
- [ ] `app/Models/Equipment.php` — связь networkMap()
- [ ] `app/Models/NetworkMap.php` — связь equipments()

---

*Документ создан на основе анализа кодовой базы и BPMN-диаграммы.*
