<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientDetail extends Model
{
    protected $fillable = [
        'client_id',
        'full_name',
        'legal_address',
        'inn',
        'kpp',
        'actual_address',
        'phone',
        'email',
        'bank_details',
        'doc_type',
        'identity_number',
    ];
    protected $table = 'client_details';

    public function clients()
    {
        return $this->belongsTo(ProviderClient::class, 'client_id');
    }
}
