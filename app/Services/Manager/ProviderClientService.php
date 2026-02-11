<?php

namespace App\Services\Manager;

use App\DTO\Manager\ProviderClient\CreateClientDto;
use App\Models\ProviderClient;

class ProviderClientService
{

    public function updateOrCreate(CreateClientDto $dto):ProviderClient
    {
        return ProviderClient::updateOrCreate(
            ['id' =>  $dto->id]
            ,[
            'name' => $dto->name,
            'contact_person' => $dto->contact_person,
            'email' => $dto->email,
            'phone' => $dto->phone,
            'type' => $dto->type,
            'address' => $dto->address,
            'inn' => $dto->inn,
            'kpp' => $dto->kpp,
            'status' => $dto->status,
            'notes' => $dto->notes,
            'user_id' => $dto->user_id,
        ]);
    }
}
