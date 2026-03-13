<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $latitude
 * @property string|null $longitude
 * @property int $is_available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NetworkMap whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NetworkMap extends Model
{
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'coverage_radius' => 'float',
        'is_available' => 'boolean',
        'technical_info' => 'array',
        'capacity' => 'integer',
        'current_load' => 'integer'
    ];

    public function getAvailableCapacityAttribute()
    {
        return ($this->capacity ?? 0) - $this->current_load;
    }

    public function getUtilizationPercentageAttribute()
    {
        if (!$this->capacity) return 0;
        return round(($this->current_load / $this->capacity) * 100, 1);
    }
}
