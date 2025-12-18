<?php

namespace App\Http\Swagger\Schemas;


/**
 * @OA\Schema(
 *     schema="PaginationMeta",
 *     type="object",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="from", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=10),
 *     @OA\Property(property="path", type="string", example="http://localhost:8000/api/manager/tariffs"),
 *     @OA\Property(property="per_page", type="integer", example=10),
 *     @OA\Property(property="to", type="integer", example=10),
 *     @OA\Property(property="total", type="integer", example=100)
 * )
 */

/**
 * @OA\Schema(
 *     schema="PaginationLinks",
 *     type="object",
 *     @OA\Property(property="first", type="string", example="http://localhost:8000/api/manager/tariffs?page=1"),
 *     @OA\Property(property="last", type="string", example="http://localhost:8000/api/manager/tariffs?page=10"),
 *     @OA\Property(property="prev", type="string", nullable=true, example=null),
 *     @OA\Property(property="next", type="string", nullable=true, example="http://localhost:8000/api/manager/tariffs?page=2")
 * )
 */

/**
 * @OA\Schema(
 *     schema="SuccessResponse",
 *     type="object",
 *     @OA\Property(property="message", type="string", example="Успешно выполнено"),
 *     @OA\Property(property="data", type="object")
 * )
 */

/**
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     type="object",
 *     @OA\Property(property="message", type="string", example="Произошла ошибка"),
 *     @OA\Property(property="errors", type="object", nullable=true)
 * )
 */
class BaseSchemas
{

}
