<?php

namespace App\Handlers\Contract;

use App\Models\Contract;
use App\Models\ServiceRequest;

class GenerateContract
{
    public function generateFromSample(ServiceRequest $serviceRequest)
    {
        $contractTitle = 'Договор на оказание услуги: ' . $serviceRequest->service->name . ' для клиента ' . $serviceRequest->providerClient->name;
        $contractAmount = $serviceRequest->service->price + $serviceRequest->equipments->sum('price');
        $contractNumber = Contract::first()->latest()->value('id') ?? 1;
        $contractNumber = $contractNumber  .'/' . Carbon::now()->month .'-Д';
        $contract = Contract::create([
           'contract_number' => $contractNumber,
           'title' => $contractTitle,
           'client_id' => $serviceRequest->providerClient->id,
           'amount' => $contractAmount,
           'status' => 'pending',
           'payment_status' => 'pending',
           'service_id' => $serviceRequest->service_id,
           'sample_id' => $serviceRequest->sample_id,
           'description' => $serviceRequest->description,
        ]);
        return $contract;
    }
}
