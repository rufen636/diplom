<?php

namespace App\Handlers\Manager\Client;

use App\DTO\Manager\ProviderClient\ClientDto;
use App\Handlers\AbstractHandler;
use App\Models\ProviderClient;
use App\Services\Manager\Provider\ProviderClient\ProviderClientService;

final class ProviderClientHandler extends AbstractHandler
{

    protected ProviderClientService $providerClientService;

    public function __construct(ProviderClientService $providerClientService)
    {
        $this->providerClientService = $providerClientService;
    }

    public function handle(ClientDto $dto): ProviderClient
    {
        return $this->providerClientService->updateOrCreate($dto);
    }
}
