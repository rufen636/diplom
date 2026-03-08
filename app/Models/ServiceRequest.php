<?php

namespace App\Models;

use App\Http\Filters\ServiceRequestFilter;
use App\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFilter;
    protected $guarded = [];
    public function scopeFilter(Builder $builder, array $data)
    {
        $postFilter = new ServiceRequestFilter();
        return $postFilter->apply($data,$builder);
    }
}
