<?php

namespace App\Http\Resources\Manager\ProviderClient;

use App\Models\ClientDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'contact_person'=> $this->contact_person,
            'email'=> $this->email,
            'phone'=> $this->phone,
            'type'=> $this->type,
            'address'=> $this->address,
            'client_details' => $this->detail ? ClientDetailResource::make($this->detail)->resolve() : null,
            'status'=> $this->status,
            'notes'=> $this->notes,

        ];
    }
}
