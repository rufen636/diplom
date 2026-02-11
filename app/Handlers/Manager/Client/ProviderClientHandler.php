<?php

namespace App\Handlers\Manager\Client;

use App\DTO\Manager\ProviderClient\CreateClientDto;
use App\Handlers\AbstractHandler;
use App\Models\ProviderClient;
use App\Services\Manager\ProviderClientService;

final class ProviderClientHandler extends AbstractHandler
{

    protected ProviderClientService $providerClientService;

    public function __construct(ProviderClientService $providerClientService)
    {
        $this->providerClientService = $providerClientService;
    }

    public function handle(CreateClientDto $dto): ProviderClient
    {
        return $this->providerClientService->updateOrCreate($dto);
    }
}
