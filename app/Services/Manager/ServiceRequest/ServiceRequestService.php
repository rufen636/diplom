<?php

namespace App\Services\Manager\ServiceRequest;

use App\DTO\Manager\ServiceRequest\ServiceRequestDto;
use App\Models\ServiceRequest;

class ServiceRequestService
{

    public function updateOrCreate(ServiceRequestDto $dto)
    {
        return ServiceRequest::updateOrCreate(['id' => $dto->id], [
            'title' => $dto->title,
            'description' => $dto->description,
            'service_id' => $dto->service_id,
            'client_id' => $dto->client_id,
            'sample_contract_id' => $dto->sample_contract_id,
            'installation_address' => $dto->installation_address,
            'status' => $dto->status,
        ]);
    }
}
