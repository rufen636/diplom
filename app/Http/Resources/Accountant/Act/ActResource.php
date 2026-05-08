<?php

namespace App\Http\Resources\Accountant\Act;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'act_number' => $this->act_number,
            'act_date' => $this->act_date,
            'act_type' => $this->act_type,
            'status' => $this->status,
            'description' => $this->description,
            'amount' => $this->amount,
        ];
    }
}
