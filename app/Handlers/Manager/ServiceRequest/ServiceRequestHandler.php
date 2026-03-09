<?php

namespace App\Handlers\Manager\ServiceRequest;

use App\DTO\Manager\ServiceRequest\ServiceRequestDto;
use App\Handlers\AbstractHandler;
use App\Models\ServiceRequest;
use App\Services\Manager\ServiceRequest\ServiceRequestService;

final class ServiceRequestHandler extends AbstractHandler
{

    protected ServiceRequestService $serviceRequestService;

    public function __construct(ServiceRequestService $serviceRequestService)
    {
        $this->serviceRequestService = $serviceRequestService;
    }

    public function handle(ServiceRequestDto $dto): ServiceRequest
    {
        return $this->serviceRequestService->updateOrCreate($dto);
    }
}
