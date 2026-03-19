<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property numeric|null $price
 * @property string|null $description
 * @property string|null $mac_address
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereMacAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Equipment extends Model
{
    protected $fillable = ['name', 'price', 'description', 'mac_address', 'ip_address'];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_equipment');
    }

    public function serviceRequests()
    {
        return $this->belongsToMany(ServiceRequest::class, 'service_request_equipment');
    }
}
