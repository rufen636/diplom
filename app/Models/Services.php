<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name Название услуги
 * @property string $code Внутренний код услуги
 * @property string|null $description Описание услуги
 * @property numeric $price Базовая цена
 * @property int $is_active Активна ли услуга
 * @property int $static_ip Статический IP
 * @property int $service_category_id
 * @property int|null $parent_id
 * @property numeric|null $internet_speed Скорость скачивания (Мбит/с)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereInternetSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereServiceCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereStaticIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Services whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Services extends Model
{
    //
}
