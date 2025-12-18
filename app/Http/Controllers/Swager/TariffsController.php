<?php

namespace App\Http\Controllers\Swager;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
/**
 * @OA\Info(
 *     title="API Documentation",
 *     version="1.0.0",
 *     description="API для управления тарифами, договорами и клиентами"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Локальный сервер"
 * )
 *
 * @OA\Tag(
 *     name="Тарифы",
 *     description="Управление тарифами"
 * )
 *
 * @OA\Tag(
 *     name="Договоры",
 *     description="Управление договорами"
 * )
 *
 * @OA\Tag(
 *     name="Клиенты провайдера",
 *     description="Управление клиентами провайдера"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class TariffsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/manager/tariffs",
     *     operationId="getTariffs",
     *     tags={"Тарифы"},
     *     summary="Получить список тарифов",
     *     description="Возвращает список тарифов с пагинацией и фильтрацией",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Номер страницы",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Количество элементов на странице",
     *         required=false,
     *         @OA\Schema(type="integer", default=10, maximum=100)
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Поиск по имени или описанию",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Фильтр по статусу",
     *         required=false,
     *         @OA\Schema(type="string", enum={"active", "inactive"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Tariff")),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Не авторизован"
     *     )
     * )
     */
    public function index(Request $request): Response
    {
        // ... ваш код
    }

    /**
     * @OA\Post(
     *     path="/api/manager/tariffs",
     *     operationId="createTariff",
     *     tags={"Тарифы"},
     *     summary="Создать новый тариф",
     *     description="Создает новый тариф",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price", "speed", "duration_months"},
     *             @OA\Property(property="name", type="string", example="Базовый тариф"),
     *             @OA\Property(property="description", type="string", example="Базовый пакет услуг", nullable=true),
     *             @OA\Property(property="price", type="number", format="float", example=1000.50),
     *             @OA\Property(property="speed", type="integer", example=100),
     *             @OA\Property(property="duration_months", type="integer", example=12),
     *             @OA\Property(property="is_active", type="boolean", example=true),
     *             @OA\Property(property="sort_order", type="integer", example=1, nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Тариф успешно создан",
     *         @OA\JsonContent(ref="#/components/schemas/Tariff")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     */
    public function store(Request $request): RedirectResponse
    {
        // ... ваш код
    }

    /**
     * @OA\Get(
     *     path="/api/manager/tariffs/{id}",
     *     operationId="getTariff",
     *     tags={"Тарифы"},
     *     summary="Получить информацию о тарифе",
     *     description="Возвращает информацию о конкретном тарифе",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID тарифа",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(ref="#/components/schemas/Tariff")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Тариф не найден"
     *     )
     * )
     */
    public function show(Tariff $tariff): Response
    {
        return Inertia::render('Manager/Tariffs/Show', [
            'tariff' => $tariff,
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/manager/tariffs/{id}",
     *     operationId="updateTariff",
     *     tags={"Тарифы"},
     *     summary="Обновить тариф",
     *     description="Обновляет информацию о тарифе",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID тарифа",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price", "speed", "duration_months"},
     *             @OA\Property(property="name", type="string", example="Обновленный тариф"),
     *             @OA\Property(property="description", type="string", example="Обновленное описание", nullable=true),
     *             @OA\Property(property="price", type="number", format="float", example=1200.00),
     *             @OA\Property(property="speed", type="integer", example=150),
     *             @OA\Property(property="duration_months", type="integer", example=24),
     *             @OA\Property(property="is_active", type="boolean", example=true),
     *             @OA\Property(property="sort_order", type="integer", example=2, nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Тариф успешно обновлен",
     *         @OA\JsonContent(ref="#/components/schemas/Tariff")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Тариф не найден"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     */
    public function update(Request $request, Tariff $tariff): RedirectResponse
    {
        // ... ваш код
    }

    /**
     * @OA\Delete(
     *     path="/api/manager/tariffs/{id}",
     *     operationId="deleteTariff",
     *     tags={"Тарифы"},
     *     summary="Удалить тариф",
     *     description="Удаляет тариф",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID тарифа",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Тариф успешно удален"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Тариф не найден"
     *     )
     * )
     */
    public function destroy(Tariff $tariff): RedirectResponse
    {
        // ... ваш код
    }
}
