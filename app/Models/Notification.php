<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'notifiable_type',
        'notifiable_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
        'action_url'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime'
    ];

    // Полиморфная связь
    public function notifiable()
    {
        return $this->morphTo();
    }

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}
