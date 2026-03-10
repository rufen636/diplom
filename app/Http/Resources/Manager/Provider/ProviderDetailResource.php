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
            'id' => $this->id ?? null,
            'full_name'=> $this->full_name ?? null,
            'legal_address'=> $this->legal_address ?? null,
            'actual_address'=> $this->actual_address ?? null,
            'phone'=> $this->phone ?? null,
            'email'=> $this->email ?? null,
            'bank_details'=> $this->bank_details ?? null,
            'website'=> $this->website ?? null,
        ];
    }
}
