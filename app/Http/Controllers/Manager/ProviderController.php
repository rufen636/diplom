<?php

namespace App\Http\Controllers\Manager;

use App\Handlers\Manager\Provider\ProviderDetailsHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\UpdateDetailsRequest;
use App\Http\Resources\Manager\Provider\ProviderDetailResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Provider;

class ProviderController extends Controller
{
    public function updateDetails(UpdateDetailsRequest $provider,ProviderDetailsHandler $handler)
    {
        $handler->handle($provider->getDto());
        return redirect()->route('manager.settings.index');
    }
}
