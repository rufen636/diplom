<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @mixin \Eloquent
 */
class BuhAct extends Model
{
    protected $fillable = [
        'act_number',
        'act_date',
        'act_type',
        'status',
        'description',
        'client_id',
        'contract_id',
        'amount',
    ];

    protected $casts = [
        'act_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function providerClient(): BelongsTo
    {
        return $this->belongsTo(ProviderClient::class, 'client_id', 'id');
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}
