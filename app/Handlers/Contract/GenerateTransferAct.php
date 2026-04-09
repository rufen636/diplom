<?php

namespace App\Handlers\Contract;

use App\Models\Contract;
use App\Models\TransferAct;
use App\Models\TransferActEquipment;
use Carbon\Carbon;

class GenerateTransferAct
{
    public function generate(Contract $contract)
    {
        $actNumber = TransferAct::latest()->value('id') ?? 1;
        $actNumber = ++$actNumber  .'/' . Carbon::now()->month .'-ТМЦ';
        $transferAct = TransferAct::create([
            'provider_client_id' => $contract->client_id,
            'contract_id' => $contract->id,
            'transfer_date' => null,
            'installation_address' => $contract->serviceRequest->installation_address,
            'created_by' => Auth()->user()->id,
            'status' => 'pending',
            'expiration_date' => null,
            'act_number' => $actNumber,
        ]);
        $equipments = $contract->serviceRequest->equipments;
        foreach ($equipments as $equipment) {
            TransferActEquipment::create([
                    'transfer_act_id' => $transferAct->id,
                    'equipment_id' => $equipment->id,
                ]
            );
        };
        return $transferAct;
    }
}
