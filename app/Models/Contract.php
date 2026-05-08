<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $contract_number
 * @property string $title
 * @property int $client_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property numeric $amount
 * @property string $status
 * @property int $service_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $status_color
 * @property-read string $status_label
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereContractNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contract whereUserId($value)
 * @mixin \Eloquent
 */
class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_number',
        'title',
        'user_id',
        'client_id',
        'sample_id',
        'start_date',
        'end_date',
        'amount',
        'status',
        'description',
        'service_request_id',
        'tariff_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Получить пользователя, связанного с договором
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить статус договора на русском языке
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Активный',
            'completed' => 'Завершен',
            'terminated' => 'Расторгнут',
            default => 'Неизвестно',
        };
    }

    /**
     * Получить цвет статуса для отображения
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800',
            'completed' => 'bg-blue-100 text-blue-800',
            'terminated' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
    public function providerClient(): BelongsTo
    {
        return $this->belongsTo(ProviderClient::class, 'client_id', 'id');
    }
    public function equipments(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'contract_equipments', 'contract_id', 'equipment_id');
    }

    public function sampleContract(): BelongsTo
    {
        return $this->belongsTo(SampleContract::class, 'sample_id', 'id');
    }
    public function serviceRequest()
    {

        return $this->belongsTo(ServiceRequest::class, 'service_request_id', 'id');
    }

}
