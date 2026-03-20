<?php

namespace App\Notifications;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ContractCreatedNotification extends Notification
{
    use Queueable;

    protected $contract;

    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    public function via($notifiable)
    {
        return ['database']; // Сохраняем в базу данных
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'contract_created',
            'title' => 'Создан новый договор',
            'message' => "Договор №{$this->contract->contract_number} был создан. Пожалуйста, укажите даты действия договора.",
            'contract_id' => $this->contract->id,
            'contract_number' => $this->contract->contract_number,
            'action_url' => route('manager.contracts.edit', $this->contract->id)
        ];
    }
}
