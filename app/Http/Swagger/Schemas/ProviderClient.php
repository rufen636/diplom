<?php

namespace App\Http\Swagger\Schemas;
/**
 * @OA\Schema(
 *     schema="ProviderClient",
 *     title="Клиент провайдера",
 *     description="Модель клиента провайдера",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="company_name", type="string", example="ООО Ромашка"),
 *     @OA\Property(property="contact_person", type="string", example="Петров Петр"),
 *     @OA\Property(property="email", type="string", format="email", example="info@romashka.ru"),
 *     @OA\Property(property="phone", type="string", example="+7 (999) 123-45-67"),
 *     @OA\Property(property="address", type="string", nullable=true, example="ул. Ленина, д. 1"),
 *     @OA\Property(property="inn", type="string", maxLength=20, nullable=true, example="1234567890"),
 *     @OA\Property(property="kpp", type="string", maxLength=20, nullable=true, example="123456789"),
 *     @OA\Property(property="status", type="string", enum={"active", "inactive", "blocked"}, example="active"),
 *     @OA\Property(property="notes", type="string", nullable=true, example="Важный клиент"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

/**
 * @OA\Schema(
 *     schema="ProviderClientRequest",
 *     title="Запрос для клиента провайдера",
 *     required={"company_name", "contact_person", "email", "phone", "status"},
 *     @OA\Property(property="company_name", type="string", maxLength=255, example="ООО Ромашка"),
 *     @OA\Property(property="contact_person", type="string", maxLength=255, example="Петров Петр"),
 *     @OA\Property(property="email", type="string", format="email", maxLength=255, example="info@romashka.ru"),
 *     @OA\Property(property="phone", type="string", maxLength=255, example="+7 (999) 123-45-67"),
 *     @OA\Property(property="address", type="string", nullable=true, example="ул. Ленина, д. 1"),
 *     @OA\Property(property="inn", type="string", maxLength=20, nullable=true, example="1234567890"),
 *     @OA\Property(property="kpp", type="string", maxLength=20, nullable=true, example="123456789"),
 *     @OA\Property(property="status", type="string", enum={"active", "inactive", "blocked"}, example="active"),
 *     @OA\Property(property="notes", type="string", nullable=true, example="Важный клиент")
 * )
 */
class ProviderClient
{

}
