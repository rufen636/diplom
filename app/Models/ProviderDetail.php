<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderDetail extends Model
{
    protected $fillable = [
        'full_name',
        'legal_address',
        'actual_address',
        'phone',
        'email',
        'bank_details',
        'website',
        'provider_client_id',
    ];

    public function providerClient(): BelongsTo
    {
        return $this->belongsTo(ProviderClient::class, 'provider_client_id', 'id');
    }
}
