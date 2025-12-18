<?php

namespace App\Http\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Tariff",
 *     title="Тариф",
 *     description="Модель тарифа",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Базовый тариф"),
 *     @OA\Property(property="description", type="string", example="Базовый пакет услуг", nullable=true),
 *     @OA\Property(property="price", type="number", format="float", example=1000.50),
 *     @OA\Property(property="speed", type="integer", example=100),
 *     @OA\Property(property="duration_months", type="integer", example=12),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(property="sort_order", type="integer", example=1, nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01 10:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01 10:00:00")
 * )
 */

/**
 * @OA\Schema(
 *     schema="TariffRequest",
 *     title="Запрос для тарифа",
 *     required={"name", "price", "speed", "duration_months"},
 *     @OA\Property(property="name", type="string", maxLength=255, example="Базовый тариф"),
 *     @OA\Property(property="description", type="string", nullable=true, example="Описание тарифа"),
 *     @OA\Property(property="price", type="number", format="float", minimum=0, example=1000.50),
 *     @OA\Property(property="speed", type="integer", minimum=1, example=100),
 *     @OA\Property(property="duration_months", type="integer", minimum=1, example=12),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(property="sort_order", type="integer", nullable=true, example=1)
 * )
 */

/**
 * @OA\Schema(
 *     schema="TariffListResponse",
 *     title="Ответ со списком тарифов",
 *     type="object",
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Tariff")
 *     ),
 *     @OA\Property(
 *         property="meta",
 *         type="object",
 *         @OA\Property(property="current_page", type="integer", example=1),
 *         @OA\Property(property="from", type="integer", example=1),
 *         @OA\Property(property="last_page", type="integer", example=10),
 *         @OA\Property(property="path", type="string", example="http://localhost:8000/api/manager/tariffs"),
 *         @OA\Property(property="per_page", type="integer", example=10),
 *         @OA\Property(property="to", type="integer", example=10),
 *         @OA\Property(property="total", type="integer", example=100)
 *     ),
 *     @OA\Property(
 *         property="links",
 *         type="object",
 *         @OA\Property(property="first", type="string", example="http://localhost:8000/api/manager/tariffs?page=1"),
 *         @OA\Property(property="last", type="string", example="http://localhost:8000/api/manager/tariffs?page=10"),
 *         @OA\Property(property="prev", type="string", nullable=true),
 *         @OA\Property(property="next", type="string", nullable=true, example="http://localhost:8000/api/manager/tariffs?page=2")
 *     )
 * )
 */
class Tariff
{

}
