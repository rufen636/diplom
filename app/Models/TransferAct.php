<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TransferAct extends Model
{
    // Связь с оборудованием через pivot таблицу transfer_act_equipment
    public function equipments(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'transfer_act_equipment', 'transfer_act_id', 'equipment_id')
            ->withTimestamps();
    }
}
