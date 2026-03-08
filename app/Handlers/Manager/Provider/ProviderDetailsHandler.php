<?php

namespace App\Handlers\Manager\Provider;

use App\DTO\Manager\ProviderDetailDto;
use App\Handlers\AbstractHandler;
use App\Models\ProviderDetail;
use App\Services\Manager\Provider\ProviderClient\ProviderClientService;
use App\Services\Manager\Provider\ProviderDetailService;

final class ProviderDetailsHandler extends AbstractHandler
{

    protected ProviderDetailService $providerDetailService;

    public function __construct(ProviderDetailService $providerDetailService)
    {
        $this->providerDetailService = $providerDetailService;
    }

    public function handle(ProviderDetailDto $dto): ProviderDetail
    {
        return $this->providerDetailService->updateOrCreate($dto);
    }
}
