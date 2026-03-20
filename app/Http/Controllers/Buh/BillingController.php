<?php

namespace App\Http\Controllers\Buh;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceIssuedToManager;
use App\Mail\PaymentCompletedToSysadmin;
use App\Mail\PaymentStatusToManager;
use App\Models\Billing;
use App\Models\Contract;
use App\Models\ProviderClient;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class BillingController extends Controller
{
    public function index(Request $request): Response
    {
        $billings = Billing::with(['providerClient', 'contract', 'tariff'])
            ->when($request->search, function ($query, $search) {
                $query->where('billing_number', 'like', "%{$search}%")
                    ->orWhereHas('providerClient', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Accountant/Billing/Index', [
            'billings' => $billings,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function create(): Response
    {
        $contracts = Contract::with(['providerClient', 'sampleContract'])
            ->whereIn('status', ['active', 'pending'])
            ->get();

        $tariffs = Tariff::active()->ordered()->get();

        return Inertia::render('Accountant/Billing/Create', [
            'contracts' => $contracts,
            'tariffs' => $tariffs,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'tariff_id' => 'required|exists:tariffs,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date|after_or_equal:period_start',
            'due_date' => 'nullable|date',
        ]);

        $contract = Contract::findOrFail($validated['contract_id']);

        $billingNumber = 'INV-' . date('Ymd') . '-' . str_pad(
            (string) (Billing::whereDate('created_at', today())->count() + 1),
            4,
            '0',
            STR_PAD_LEFT
        );

        $billing = Billing::create([
            ...$validated,
            'billing_number' => $billingNumber,
            'client_id' => $contract->client_id,
            'accountant_id' => auth()->id(),
            'status' => 'pending',
            'billing_date' => now(),
        ]);

        $managers = User::role('manager')->get();
        foreach ($managers as $manager) {
            Mail::to($manager->email)->send(new InvoiceIssuedToManager($billing));
        }

        return redirect()->route('accountant.billing.index')
            ->with('success', 'Счёт успешно создан.');
    }

    public function updateStatus(Request $request, Billing $billing): RedirectResponse
    {
        $request->validate(['status' => 'required|in:created,pending,paid,completed,expired']);

        $previousStatus = $billing->status;
        $billing->update([
            'status' => $request->status,
            'paid_date' => $request->status === 'paid' ? now() : $billing->paid_date,
        ]);

        if ($request->status === 'paid' && $previousStatus !== 'paid') {
            $sysadmins = User::role('sysadmin')->get();
            foreach ($sysadmins as $sysadmin) {
                Mail::to($sysadmin->email)->send(new PaymentCompletedToSysadmin($billing));
            }
            $managers = User::role('manager')->get();
            foreach ($managers as $manager) {
                Mail::to($manager->email)->send(new PaymentStatusToManager($billing));
            }
        }

        return redirect()->back()->with('success', 'Статус обновлён.');
    }
}
