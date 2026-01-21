<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $request_number
 * @property string $priority Приоритет заявки
 * @property string $status Статус заявки
 * @property string $requested_at Дата и время создания заявки
 * @property string|null $closed_at Дата и время закрытия
 * @property int $client_id
 * @property int|null $service_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereClosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereRequestNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereRequestedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClientRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClientRequest extends Model
{
    //
}
