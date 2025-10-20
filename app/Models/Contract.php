<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_number',
        'title',
        'user_id',
        'start_date',
        'end_date',
        'amount',
        'status',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Получить пользователя, связанного с договором
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить статус договора на русском языке
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Активный',
            'completed' => 'Завершен',
            'terminated' => 'Расторгнут',
            default => 'Неизвестно',
        };
    }

    /**
     * Получить цвет статуса для отображения
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800',
            'completed' => 'bg-blue-100 text-blue-800',
            'terminated' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
