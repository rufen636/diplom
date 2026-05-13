<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    description: 'Документация по основным роутам менеджера',
    title: 'Diplom API'
)]
#[OA\Server(
    url: 'http://localhost',
    description: 'Основной сервер'
)]
#[OA\SecurityScheme(
    securityScheme: 'sanctum',
    type: 'apiKey',
    in: 'header',
    name: 'Authorization',
    description: 'Введите токен в формате: Bearer {token}'
)]
#[OA\Tag(name: 'Tariffs', description: 'Управление тарифами (веб, Inertia, требуется CSRF)')]
#[OA\Tag(name: 'Contracts', description: 'Управление договорами (веб, Inertia, требуется CSRF)')]
#[OA\Tag(name: 'ProviderClients', description: 'Управление клиентами провайдера (веб, Inertia, требуется CSRF)')]
#[OA\Tag(name: 'TariffsJsonApi', description: 'JSON API тарифов по префиксу /api/v1 (Sanctum, без CSRF)')]
class MainApiDocumentation
{
    #[OA\Get(
        path: '/manager/tariffs',
        operationId: 'getTariffsList',
        summary: 'Список тарифов',
        security: [['sanctum' => []]],
        tags: ['Tariffs'],
        parameters: [
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'status', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
        ],
        responses: [new OA\Response(response: 200, description: 'Успешно')]
    )]
    public function tariffsIndex(): void
    {
    }

    #[OA\Post(
        path: '/manager/tariffs',
        operationId: 'storeTariff',
        summary: 'Создать тариф',
        security: [['sanctum' => []]],
        tags: ['Tariffs'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'price', 'speed', 'duration_months'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Тариф Старт'),
                    new OA\Property(property: 'price', type: 'number', format: 'float', example: 999.99),
                    new OA\Property(property: 'speed', type: 'integer', example: 100),
                    new OA\Property(property: 'duration_months', type: 'integer', example: 12),
                ]
            )
        ),
        responses: [new OA\Response(response: 302, description: 'Редирект после создания')]
    )]
    public function tariffsStore(): void
    {
    }

    #[OA\Get(
        path: '/manager/contracts',
        operationId: 'getContractsList',
        summary: 'Список договоров',
        security: [['sanctum' => []]],
        tags: ['Contracts'],
        responses: [new OA\Response(response: 200, description: 'Успешно')]
    )]
    public function contractsIndex(): void
    {
    }

    #[OA\Post(
        path: '/manager/contracts',
        operationId: 'storeContract',
        summary: 'Создать договор',
        security: [['sanctum' => []]],
        tags: ['Contracts'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['contract_number', 'title', 'user_id', 'start_date', 'end_date', 'amount', 'status'],
                properties: [
                    new OA\Property(property: 'contract_number', type: 'string', example: 'CTR-2026-001'),
                    new OA\Property(property: 'title', type: 'string', example: 'Договор услуг'),
                    new OA\Property(property: 'user_id', type: 'integer', example: 1),
                    new OA\Property(property: 'start_date', type: 'string', format: 'date', example: '2026-01-01'),
                    new OA\Property(property: 'end_date', type: 'string', format: 'date', example: '2026-12-31'),
                    new OA\Property(property: 'amount', type: 'number', format: 'float', example: 15000.00),
                    new OA\Property(property: 'status', type: 'string', example: 'active'),
                ]
            )
        ),
        responses: [new OA\Response(response: 302, description: 'Редирект после создания')]
    )]
    public function contractsStore(): void
    {
    }

    #[OA\Get(
        path: '/manager/provider-clients',
        operationId: 'getProviderClientsList',
        summary: 'Список клиентов провайдера',
        security: [['sanctum' => []]],
        tags: ['ProviderClients'],
        responses: [new OA\Response(response: 200, description: 'Успешно')]
    )]
    public function providerClientsIndex(): void
    {
    }

    #[OA\Post(
        path: '/manager/provider-clients',
        operationId: 'storeProviderClient',
        summary: 'Создать клиента провайдера',
        security: [['sanctum' => []]],
        tags: ['ProviderClients'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'contact_person', 'email', 'phone', 'type', 'status'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'ООО Альфа'),
                    new OA\Property(property: 'contact_person', type: 'string', example: 'Иванов И.И.'),
                    new OA\Property(property: 'email', type: 'string', example: 'alpha@example.com'),
                    new OA\Property(property: 'phone', type: 'string', example: '+79990001122'),
                    new OA\Property(property: 'type', type: 'string', example: 'company'),
                    new OA\Property(property: 'status', type: 'string', example: 'active'),
                ]
            )
        ),
        responses: [new OA\Response(response: 302, description: 'Редирект после создания')]
    )]
    public function providerClientsStore(): void
    {
    }

    #[OA\Get(
        path: '/api/v1/tariffs',
        operationId: 'apiV1TariffsIndex',
        summary: 'Список тарифов (JSON)',
        security: [['sanctum' => []]],
        tags: ['TariffsJsonApi'],
        responses: [
            new OA\Response(response: 200, description: 'OK', content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'data',
                        type: 'array',
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'id', type: 'integer'),
                                new OA\Property(property: 'name', type: 'string'),
                                new OA\Property(property: 'price', type: 'number', format: 'float'),
                                new OA\Property(property: 'speed', type: 'integer'),
                                new OA\Property(property: 'duration_months', type: 'integer'),
                                new OA\Property(property: 'is_active', type: 'boolean'),
                                new OA\Property(property: 'user_id', type: 'integer'),
                            ],
                            type: 'object'
                        )
                    ),
                ]
            )),
            new OA\Response(response: 401, description: 'Не авторизован'),
        ]
    )]
    public function apiTariffsIndex(): void
    {
    }

    #[OA\Post(
        path: '/api/v1/tariffs',
        operationId: 'apiV1TariffsStore',
        summary: 'Создать тариф (JSON)',
        security: [['sanctum' => []]],
        tags: ['TariffsJsonApi'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'price', 'speed', 'duration_months'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Тариф API'),
                    new OA\Property(property: 'description', type: 'string', nullable: true),
                    new OA\Property(property: 'price', type: 'number', format: 'float', example: 890),
                    new OA\Property(property: 'speed', type: 'integer', example: 200),
                    new OA\Property(property: 'duration_months', type: 'integer', example: 6),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                    new OA\Property(property: 'sort_order', type: 'integer', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Создано'),
            new OA\Response(response: 401, description: 'Не авторизован'),
            new OA\Response(response: 422, description: 'Ошибка валидации'),
        ]
    )]
    public function apiTariffsStore(): void
    {
    }

    #[OA\Patch(
        path: '/api/v1/tariffs/{tariff}',
        operationId: 'apiV1TariffsUpdate',
        summary: 'Обновить тариф (JSON)',
        security: [['sanctum' => []]],
        tags: ['TariffsJsonApi'],
        parameters: [
            new OA\Parameter(name: 'tariff', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'price', 'speed', 'duration_months'],
                properties: [
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'description', type: 'string', nullable: true),
                    new OA\Property(property: 'price', type: 'number', format: 'float'),
                    new OA\Property(property: 'speed', type: 'integer'),
                    new OA\Property(property: 'duration_months', type: 'integer'),
                    new OA\Property(property: 'is_active', type: 'boolean'),
                    new OA\Property(property: 'sort_order', type: 'integer', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 401, description: 'Не авторизован'),
            new OA\Response(response: 403, description: 'Чужой тариф'),
            new OA\Response(response: 422, description: 'Ошибка валидации'),
        ]
    )]
    public function apiTariffsUpdate(): void
    {
    }

    #[OA\Delete(
        path: '/api/v1/tariffs/{tariff}',
        operationId: 'apiV1TariffsDestroy',
        summary: 'Удалить тариф (JSON)',
        security: [['sanctum' => []]],
        tags: ['TariffsJsonApi'],
        parameters: [
            new OA\Parameter(name: 'tariff', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 204, description: 'Удалено'),
            new OA\Response(response: 401, description: 'Не авторизован'),
            new OA\Response(response: 403, description: 'Чужой тариф'),
        ]
    )]
    public function apiTariffsDestroy(): void
    {
    }

    #[OA\Patch(
        path: '/manager/contracts/{contract}',
        operationId: 'managerContractsUpdate',
        summary: 'Обновить договор (веб, PUT/PATCH через форму; нужен CSRF)',
        security: [['sanctum' => []]],
        tags: ['Contracts'],
        parameters: [
            new OA\Parameter(name: 'contract', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'contract_number', type: 'string'),
                    new OA\Property(property: 'title', type: 'string'),
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'start_date', type: 'string', format: 'date'),
                    new OA\Property(property: 'end_date', type: 'string', format: 'date'),
                    new OA\Property(property: 'amount', type: 'number', format: 'float'),
                    new OA\Property(property: 'status', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 302, description: 'Редирект после обновления'),
        ]
    )]
    public function contractsUpdateDoc(): void
    {
    }

    #[OA\Delete(
        path: '/manager/contracts/{contract}',
        operationId: 'managerContractsDestroy',
        summary: 'Удалить договор (веб; нужен CSRF)',
        security: [['sanctum' => []]],
        tags: ['Contracts'],
        parameters: [
            new OA\Parameter(name: 'contract', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 302, description: 'Редирект после удаления'),
        ]
    )]
    public function contractsDestroyDoc(): void
    {
    }

    #[OA\Patch(
        path: '/manager/tariffs/{tariff}',
        operationId: 'managerTariffsUpdate',
        summary: 'Обновить тариф (веб; нужен CSRF)',
        security: [['sanctum' => []]],
        tags: ['Tariffs'],
        parameters: [
            new OA\Parameter(name: 'tariff', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'price', type: 'number', format: 'float'),
                    new OA\Property(property: 'speed', type: 'integer'),
                    new OA\Property(property: 'duration_months', type: 'integer'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 302, description: 'Редирект после обновления'),
        ]
    )]
    public function tariffsUpdateDoc(): void
    {
    }

    #[OA\Delete(
        path: '/manager/tariffs/{tariff}',
        operationId: 'managerTariffsDestroy',
        summary: 'Удалить тариф (веб; нужен CSRF)',
        security: [['sanctum' => []]],
        tags: ['Tariffs'],
        parameters: [
            new OA\Parameter(name: 'tariff', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 302, description: 'Редирект после удаления'),
        ]
    )]
    public function tariffsDestroyDoc(): void
    {
    }

    #[OA\Patch(
        path: '/manager/provider-clients/{provider_client}',
        operationId: 'managerProviderClientsUpdate',
        summary: 'Обновить клиента провайдера (веб; нужен CSRF)',
        security: [['sanctum' => []]],
        tags: ['ProviderClients'],
        parameters: [
            new OA\Parameter(name: 'provider_client', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 302, description: 'Редирект после обновления'),
        ]
    )]
    public function providerClientsUpdateDoc(): void
    {
    }

    #[OA\Delete(
        path: '/manager/provider-clients/{provider_client}',
        operationId: 'managerProviderClientsDestroy',
        summary: 'Удалить клиента провайдера (веб; нужен CSRF)',
        security: [['sanctum' => []]],
        tags: ['ProviderClients'],
        parameters: [
            new OA\Parameter(name: 'provider_client', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 302, description: 'Редирект после удаления'),
        ]
    )]
    public function providerClientsDestroyDoc(): void
    {
    }
}
