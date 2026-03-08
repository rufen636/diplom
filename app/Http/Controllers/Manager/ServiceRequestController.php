<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\Manager\ProviderClient\ClientResource;
use App\Http\Resources\Manager\SampleContract\SampleContractResource;
use App\Http\Resources\Manager\Service\ServiceResource;
use App\Models\ProviderClient;
use App\Models\SampleContract;
use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceRequestController extends Controller
{
    public function create()
    {
        $provider_clients = ClientResource::collection(ProviderClient::where('status','active')->get())->resolve();
        $services = ServiceResource::collection(Service::where('is_active',true)->get())->resolve();
        $sample_contracts = SampleContractResource::collection(SampleContract::where('status','active')->get())->resolve();
        return Inertia::render('Manager/ServiceRequest/Create',['provider_clients'=>$provider_clients,'services'=>$services,'sample_contracts'=>$sample_contracts]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Inertia::render('Manager/ServiceRequest/Index', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        //
    }
}
