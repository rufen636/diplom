<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $billing_number
 * @property float $amount
 * @property int $client_id
 * @property string $status
 * @property string|null $description
 * @property string|null $note
 * @property float|null $tax_amount
 * @property int $tariff_id
 * @property int $accountant_id
 * @property int $contract_id
 * @property string|null $billing_date Дата формирования счета
 * @property string|null $invoice_url
 * @property string|null $due_date Срок оплаты
 * @property string|null $paid_date Дата оплаты
 * @property string|null $period_start Начало расчетного периода
 * @property string|null $period_end Конец расчетного периода
 * @property int|null $service_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @mixin \Eloquent
 */
class Billing extends Model
{
    protected $fillable = [
        'billing_number',
        'amount',
        'client_id',
        'status',
        'description',
        'note',
        'tax_amount',
        'tariff_id',
        'accountant_id',
        'contract_id',
        'billing_date',
        'invoice_url',
        'due_date',
        'paid_date',
        'period_start',
        'period_end',
        'service_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'billing_date' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
        'period_start' => 'date',
        'period_end' => 'date',
    ];

    public function providerClient(): BelongsTo
    {
        return $this->belongsTo(ProviderClient::class, 'client_id', 'id');
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }

    public function accountant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accountant_id', 'id');
    }
}
