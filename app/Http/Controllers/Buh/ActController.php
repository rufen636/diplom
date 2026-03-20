<?php

namespace App\Http\Controllers\Buh;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\BuhAct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ActController extends Controller
{
    public function create(): Response
    {
        $billings = Billing::with(['providerClient', 'contract'])
            ->where('status', 'paid')
            ->latest()
            ->get();

        return Inertia::render('Accountant/Act/Create', [
            'billings' => $billings,
        ]);
    }

    public function index(Request $request): Response
    {
        $acts = BuhAct::with(['providerClient', 'contract'])
            ->when($request->search, function ($query, $search) {
                $query->where('act_number', 'like', "%{$search}%")
                    ->orWhereHas('providerClient', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Accountant/Act/Index', [
            'acts' => $acts,
            'filters' => $request->only(['search']),
        ]);
    }

    public function generateActs(Request $request): RedirectResponse
    {
        $request->validate([
            'billing_ids' => 'required|array',
            'billing_ids.*' => 'exists:billings,id',
        ]);

        $billings = Billing::whereIn('id', $request->billing_ids)
            ->where('status', 'paid')
            ->with(['providerClient', 'contract'])
            ->get();

        $created = 0;
        foreach ($billings as $billing) {
            $exists = BuhAct::where('contract_id', $billing->contract_id)
                ->where('act_date', $billing->paid_date?->format('Y-m-d'))
                ->exists();

            if (!$exists) {
                BuhAct::create([
                    'act_number' => 'ACT-' . date('Ymd') . '-' . str_pad((string) (BuhAct::whereDate('created_at', today())->count() + 1), 4, '0', STR_PAD_LEFT),
                    'act_date' => $billing->paid_date ?? now(),
                    'act_type' => 'monthly',
                    'status' => 'sent',
                    'client_id' => $billing->client_id,
                    'contract_id' => $billing->contract_id,
                    'amount' => $billing->amount,
                ]);
                $created++;
            }
        }

        return redirect()->route('accountant.acts.index')
            ->with('success', "Создано актов: {$created}.");
    }
}
