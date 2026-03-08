<?php

namespace App\Http\Controllers\Manager;

use App\Handlers\Manager\Client\ProviderClientHandler;
use App\Handlers\Manager\SampleContract\SampleContractHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\SampleConctract\IndexRequest;
use App\Http\Requests\Manager\SampleContract\SampleContractRequest;
use App\Http\Resources\Manager\SampleContract\SampleContractCollection;
use App\Http\Resources\Manager\SampleContract\SampleContractResource;
use App\Models\SampleContract;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SampleContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validationData();
        $sampleContracts = SampleContractResource::collection(SampleContract::paginate($data['per_page'],'*','page',$data['page']));
        if (\Illuminate\Support\Facades\Request::wantsJson()) {
            return $sampleContracts;
        }
        return Inertia::render('Manager/SampleContract/Index', ['sampleContracts' => $sampleContracts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SampleContractRequest $request,SampleContractHandler $handler)
    {

        $handler->handle($request->getDto());
    }
    public function create()
    {

        return Inertia::render('Manager/SampleContract/Create', []);
    }

    /**
     * Display the specified resource.
     */
    public function show(SampleContract $sampleContract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SampleContractRequest $request, SampleContractHandler $handler)
    {
        $handler->handle($request->getDto());
        return redirect()->route('manager.sample-contract.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SampleContract $sampleContract)
    {
        $sampleContract->delete();
        return redirect()->route('manager.sample-contract.index');
    }
}
