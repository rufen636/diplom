<?php

namespace App\Services\Manager\Provider\ProviderClient;

use App\DTO\Manager\ProviderClient\ClientDto;
use App\Models\ClientDetail;
use App\Models\ProviderClient;
use Illuminate\Support\Facades\DB;

class ProviderClientService
{

    public function updateOrCreate(ClientDto $dto)
    {
        try {
            DB::beginTransaction();
            $provider_client = ProviderClient::updateOrCreate(
                ['id' => $dto->id]
                , [
                'name' => $dto->name,
                'contact_person' => $dto->contact_person,
                'email' => $dto->email,
                'phone' => $dto->phone,
                'type' => $dto->type,
                'address' => $dto->address,
                'status' => $dto->status,
                'notes' => $dto->notes,
                'user_id' => $dto->user_id,
            ]);
            ClientDetail::updateOrCreate(['client_id' => $provider_client->id], [
                'client_id' => $provider_client->id,
                'full_name' => $dto->client_details['full_name'],
                'legal_address' => $dto->client_details['legal_address'],
                'inn' => $dto->client_details['inn'],
                'kpp' => $dto->client_details['kpp'],
                'actual_address' => $dto->client_details['actual_address'],
                'bank_details' => $dto->client_details['bank_details'],
                'doc_type' => $dto->client_details['doc_type'],
                'identity_number' => $dto->client_details['identity_number'],
            ]);
            DB::commit();
            return $provider_client;
        }catch (\Exception $exception){
            \Log::error($exception->getMessage());
            DB::rollBack();
            return response()->json(['message' => 'Ошибка при записи или обновлении'], 500);
        }

    }
}
