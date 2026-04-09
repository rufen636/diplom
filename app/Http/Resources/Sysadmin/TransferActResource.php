<?php

namespace App\Http\Resources\Sysadmin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferActResource extends JsonResource
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
            'transfer_date' => $this->transfer_date,
            'installation_address' => $this->installation_address,
            'status' => $this->status,
            'expiration_date' => $this->expiration_date,
            'act_number' => $this->act_number
        ];
    }
}
