<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $contact_person
 * @property string $email
 * @property string $phone
 * @property string $type
 * @property string|null $address
 * @property string|null $inn
 * @property string|null $kpp
 * @property string $status
 * @property string|null $notes
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereKpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProviderClient whereUserId($value)
 * @mixin \Eloquent
 */
class ProviderClient extends Model
{
    protected $fillable = [
        'id',
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'inn',
        'kpp',
        'status',
        'notes',
        'user_id',
    ];

    /**
     * Scope для активных клиентов
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Проверка, активен ли клиент
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Проверка, заблокирован ли клиент
     */
    public function isBlocked(): bool
    {
        return $this->status === 'blocked';
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class,'client_id','id');
    }
}
