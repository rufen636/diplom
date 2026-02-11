<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereAccountantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereBillingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereBillingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereInvoiceUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing wherePaidDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing wherePeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing wherePeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTariffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Billing extends Model
{
    //
}
