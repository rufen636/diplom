<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EquipmentCategory extends Model
{
    //
}
