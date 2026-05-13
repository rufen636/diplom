<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;
/**
 * @OA\Schema (
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
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property numeric $price
 * @property int $speed
 * @property int $duration_months
 * @property bool $is_active
 * @property int $sort_order
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereDurationMonths($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tariff whereUserId($value)
 * @mixin \Eloquent
 */
class Tariff extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'speed',
        'duration_months',
        'is_active',
        'sort_order',
        'user_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Scope для активных тарифов
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope для сортировки
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
