<?php

namespace App\Http\Resources\Manager\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'price' => $this->price,
            'is_active' => $this->is_active,
            'static_ip' => $this->static_ip,
            'service_category_id' => $this->service_category_id,
            'parent_id' => $this->parent_id,
            'internet_speed' => $this->internet_speed,
        ];
    }
}
