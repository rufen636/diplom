<?php

namespace App\Handlers\Manager\SampleContract;

use App\DTO\Manager\SampleContract\SampleContractDto;
use App\DTO\Manager\SampleContract\ServiceRequestDto;
use App\Handlers\AbstractHandler;
use App\Models\SampleContract;
use App\Services\Manager\SampleContract\SampleContractService;

final class SampleContractHandler extends AbstractHandler
{

    protected SampleContractService $sampleContractService;

    public function __construct(SampleContractService $sampleContractService)
    {
        $this->sampleContractService = $sampleContractService;
    }

    public function handle(SampleContractDto $dto): SampleContract
    {
        return $this->sampleContractService->updateOrCreate($dto);
    }
}
