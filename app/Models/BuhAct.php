<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $act_number
 * @property string $act_date
 * @property string $act_type
 * @property string $status
 * @property string|null $description
 * @property int $client_id
 * @property int $contract_id
 * @property numeric $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereActDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereActNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereActType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BuhAct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BuhAct extends Model
{
    //
}
