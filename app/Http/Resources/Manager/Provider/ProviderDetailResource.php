<?php

namespace App\Http\Resources\Manager\Provider;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name'=> $this->full_name,
            'legal_address'=> $this->legal_address,
            'actual_address'=> $this->actual_address,
            'phone'=> $this->phone,
            'email'=> $this->email,
            'bank_details'=> $this->bank_details,
            'website'=> $this->website,
        ];
    }
}
