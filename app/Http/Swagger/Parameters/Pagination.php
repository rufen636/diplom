<?php

namespace App\Http\Swagger\Parameters;

/**
 * @OA\Schema(
 *     schema="PaginationMeta",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="from", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=10),
 *     @OA\Property(property="path", type="string", example="http://api.example.com/tariffs"),
 *     @OA\Property(property="per_page", type="integer", example=10),
 *     @OA\Property(property="to", type="integer", example=10),
 *     @OA\Property(property="total", type="integer", example=100)
 * )
 */

/**
 * @OA\Schema(
 *     schema="PaginationLinks",
 *     @OA\Property(property="first", type="string", example="http://api.example.com/tariffs?page=1"),
 *     @OA\Property(property="last", type="string", example="http://api.example.com/tariffs?page=10"),
 *     @OA\Property(property="prev", type="string", nullable=true, example="http://api.example.com/tariffs?page=1"),
 *     @OA\Property(property="next", type="string", nullable=true, example="http://api.example.com/tariffs?page=2")
 * )
 */

/**
 * @OA\Parameter(
 *     parameter="PageParameter",
 *     name="page",
 *     in="query",
 *     description="Номер страницы",
 *     required=false,
 *     @OA\Schema(type="integer", default=1)
 * )
 *
 * @OA\Parameter(
 *     parameter="PerPageParameter",
 *     name="per_page",
 *     in="query",
 *     description="Количество элементов на странице",
 *     required=false,
 *     @OA\Schema(type="integer", default=10, maximum=100)
 * )
 */
class Pagination
{

}
