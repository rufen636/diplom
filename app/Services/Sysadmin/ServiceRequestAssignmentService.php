<?php

namespace App\Services\Sysadmin;

use App\Mail\RequestAssignedToManager;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ServiceRequestAssignmentService
{
    /**
     * Отправка уведомления менеджеру о привязке оборудования к заявке
     */
    public function notifyManager(ServiceRequest $serviceRequest): void
    {
        $managers = User::role('manager')->get();

        foreach ($managers as $manager) {
            Mail::to($manager->email)->send(new RequestAssignedToManager($manager->email, $serviceRequest));
        }
    }
}
