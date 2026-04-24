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
#[OA\Tag(name: 'Tariffs', description: 'Управление тарифами')]
#[OA\Tag(name: 'Contracts', description: 'Управление договорами')]
#[OA\Tag(name: 'ProviderClients', description: 'Управление клиентами провайдера')]
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
}
