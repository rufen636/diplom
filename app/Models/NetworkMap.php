<?php
// app/Models/NetworkMap.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NetworkMap extends Model
{
    protected $table = 'network_maps';

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'is_available',
        'address',
        'coverage_radius',
        'technical_info',
        'capacity',
        'current_load'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'coverage_radius' => 'float',
        'is_available' => 'boolean',
        'technical_info' => 'array',
        'capacity' => 'integer',
        'current_load' => 'integer'
    ];


    // Аксессоры
    public function getAvailableCapacityAttribute()
    {
        return ($this->capacity ?? 0) - ($this->current_load ?? 0);
    }

    public function getUtilizationPercentageAttribute()
    {
        if (!$this->capacity) return 0;
        return round(($this->current_load / $this->capacity) * 100, 1);
    }
}
