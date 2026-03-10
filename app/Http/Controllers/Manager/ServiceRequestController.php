<?php

namespace App\Http\Controllers\Manager;
use App\Handlers\Manager\ServiceRequest\ServiceRequestHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\ServiceRequest\ServiceRequestRequest;
use App\Http\Resources\Manager\ProviderClient\ClientResource;
use App\Http\Resources\Manager\SampleContract\SampleContractResource;
use App\Http\Resources\Manager\Service\ServiceResource;
use App\Http\Resources\Manager\ServiceRequest\ServiceRequestResource;
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
        $provider_clients_company = ClientResource::collection(ProviderClient::where('status','active')->where('type','company')->get())->resolve();
        $provider_clients_person = ClientResource::collection(ProviderClient::where('status','active')->where('type','person')->get())->resolve();
        $services = ServiceResource::collection(Service::where('is_active',true)->get())->resolve();
        $sample_contracts_person = SampleContractResource::collection(SampleContract::where('status','active')->where('contract_type','individual')->get())->resolve();
        $sample_contracts_company = SampleContractResource::collection(SampleContract::where('status','active')->where('contract_type','company')->get())->resolve();
        return Inertia::render('Manager/ServiceRequest/Create',['provider_clients_person'=>$provider_clients_person,'provider_clients_company'=>$provider_clients_company,'services'=>$services,'sample_contracts_company'=>$sample_contracts_company,'sample_contracts_person'=>$sample_contracts_person]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service_requests = ServiceRequestResource::collection(ServiceRequest::all())->resolve();
        return Inertia::render('Manager/ServiceRequest/Index', ['service_requests'=>$service_requests]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequestRequest $request,ServiceRequestHandler $handler)
    {
        $handler->handle($request->getDto());
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
