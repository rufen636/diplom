<?php

namespace App\Http\Resources\Manager\ServiceRequest;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'service_id' => $this->service_id,
            'client_id' => $this->client_id,
            'sample_contract_id' => $this->sample_contract_id,
            'installation_address' => $this->installation_address,
            'client_name' => $this->providerClient->name ?? null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'equipments' => $this->whenLoaded('equipments', fn () => $this->equipments->map(fn ($e) => [
                'id' => $e->id,
                'name' => $e->name,
            ])->toArray()),
            'service' => $this->whenLoaded('service', fn () => $this->service ? [
                'id' => $this->service->id,
                'name' => $this->service->name,
            ] : null),
        ];
    }
}
