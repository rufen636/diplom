<?php

namespace App\Http\Swagger\Schemas;
/**
 * @OA\Schema(
 *     schema="Contract",
 *     title="Договор",
 *     description="Модель договора",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="contract_number", type="string", example="ДГ-2024-001"),
 *     @OA\Property(property="title", type="string", example="Договор на оказание услуг"),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="start_date", type="string", format="date", example="2024-01-01"),
 *     @OA\Property(property="end_date", type="string", format="date", example="2024-12-31"),
 *     @OA\Property(property="amount", type="number", format="float", example=50000.00),
 *     @OA\Property(property="status", type="string", enum={"active", "completed", "terminated"}, example="active"),
 *     @OA\Property(property="description", type="string", nullable=true, example="Дополнительная информация"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="user",
 *         ref="#/components/schemas/User"
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="ContractRequest",
 *     title="Запрос для договора",
 *     required={"contract_number", "title", "user_id", "start_date", "end_date", "amount", "status"},
 *     @OA\Property(property="contract_number", type="string", maxLength=255, example="ДГ-2024-001"),
 *     @OA\Property(property="title", type="string", maxLength=255, example="Договор на оказание услуг"),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="start_date", type="string", format="date", example="2024-01-01"),
 *     @OA\Property(property="end_date", type="string", format="date", example="2024-12-31"),
 *     @OA\Property(property="amount", type="number", format="float", minimum=0, example=50000.00),
 *     @OA\Property(property="status", type="string", enum={"active", "completed", "terminated"}, example="active"),
 *     @OA\Property(property="description", type="string", nullable=true, example="Дополнительная информация")
 * )
 */

/**
 * @OA\Schema(
 *     schema="User",
 *     title="Пользователь",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Иван Иванов"),
 *     @OA\Property(property="email", type="string", format="email", example="ivan@example.com")
 * )
 */
class Contract
{

}
