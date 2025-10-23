<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderClient extends Model
{
    protected $fillable = [
        'company_name',
        'contact_person',
        'email',
        'phone',
        'address',
        'inn',
        'kpp',
        'status',
        'notes',
    ];

    /**
     * Scope для активных клиентов
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Проверка, активен ли клиент
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Проверка, заблокирован ли клиент
     */
    public function isBlocked(): bool
    {
        return $this->status === 'blocked';
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
