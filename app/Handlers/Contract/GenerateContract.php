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
        Contract::create([
           'contract_number' => $serviceRequest->title,
           'title' => $contractTitle,
           'client_id' => $serviceRequest->provider_client_id,
           'amount' => $contractAmount,
           'status' => 'pending',
           'payment_status' => 'pending',
           'service_id' => $serviceRequest->payment_status,
           'sample_id' => $serviceRequest->service_id,
           'description' => $serviceRequest->sample_id,
           'service_request_id' => $serviceRequest->id
        ]);
    }
}
