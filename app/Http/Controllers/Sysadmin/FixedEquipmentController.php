<?php

namespace App\Http\Controllers\Sysadmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Sysadmin\TransferActResource;
use App\Models\Equipment;
use App\Models\TransferAct;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FixedEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transferActs = TransferActResource::collection(TransferAct::query()->paginate());
        return Inertia::render('Sysadmin/TransferAct/Index', ['transferActs' => $transferActs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function edit(TransferAct $fixed_equipment)
    {
        $transferAct = TransferActResource::make($fixed_equipment)->resolve();
        return Inertia::render('Sysadmin/TransferAct/Edit', ['transferAct' => $transferAct]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TransferAct $transferAct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransferAct $fixed_equipment)
    {
        $fixed_equipment->update([
            'transfer_date' => $request->input('transfer_date'),
            'status' => $request->input('status'),
        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(TransferAct $fixed_equipment)
    {
        try {

            $fixed_equipment->delete();

            return redirect()->back()->with('success', 'Акт успешно удален');
        } catch (\Exception $e) {
            \Log::error('Ошибка удаления: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Не удалось удалить акт: ' . $e->getMessage());
        }
    }
    public function generateAct(TransferAct $transferAct)
    {

        $pdf = Pdf::loadView('view.transfer_act',['transferAct'=>$transferAct]);
        return $pdf->download('act-'. $transferAct->id . '.pdf');
    }
}
