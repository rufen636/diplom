<?php

namespace App\Listeners;

use App\Events\ContractCreated;
use App\Notifications\ContractCreatedNotification;
use Illuminate\Support\Facades\Log;

class SendContractCreatedNotification
{
    public function handle(ContractCreated $event)
    {
        $contract = $event->contract;

        Log::info("Contract created: {$contract->contract_number}, manager_id: {$contract->manager_id}");

        // Получаем пользователя (менеджера)
        $manager = \App\Models\User::role('manager')->firstOrFail();

        if ($manager) {
            // Отправляем уведомление через стандартную систему Laravel
            $manager->notify(new ContractCreatedNotification($contract));
            Log::info("Notification sent to manager: {$manager->email}");
        } else {
//            Log::error("Manager not found with id: {$contract->manager_id}");
        }
    }
}
