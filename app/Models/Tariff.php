<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
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
