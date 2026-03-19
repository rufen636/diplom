<?php

namespace App\Handlers\Manager\ServiceRequest;

use App\DTO\Manager\ServiceRequest\ServiceRequestDto;
use App\Handlers\AbstractHandler;
use App\Mail\RequestInspection;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Services\Manager\ServiceRequest\ServiceRequestService;
use Illuminate\Support\Facades\Mail;

final class ServiceRequestHandler extends AbstractHandler
{

    protected ServiceRequestService $serviceRequestService;

    public function __construct(ServiceRequestService $serviceRequestService)
    {
        $this->serviceRequestService = $serviceRequestService;
    }

    public function handle(ServiceRequestDto $dto): ServiceRequest
    {
        $service_request = $this->serviceRequestService->updateOrCreate($dto);
        if ($dto->status === "on_inspection"){
            $user = User::role('sysadmin')->first();
            Mail::to($user)->send(new RequestInspection($user->email,$service_request));
        }
        return $service_request;
    }
}
