<?php

namespace App\Http\Resources\Manager\ProviderClient;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'full_name' => $this->full_name,
            'legal_address' => $this->legal_address,
            'inn' => $this->inn,
            'kpp' => $this->kpp,
            'actual_address' => $this->actual_address,
            'phone' => $this->phone,
            'email' => $this->email,
            'bank_details' => $this->bank_details,
            'doc_type' => $this->doc_type,
            'identity_number' => $this->identity_number,
        ];
    }
}
