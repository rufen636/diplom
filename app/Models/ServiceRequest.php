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
    public function providerClient()
    {
        return $this->belongsTo(ProviderClient::class,'client_id','id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id','id');
    }
    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, 'service_request_equipment');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function scopeOnInspection($query)
    {
        return $query->where('status', 'on_inspection');
    }

    public function scopeWithEquipmentAssigned($query)
    {
        return $query->where('status', 'equipment_assigned');
    }
    public function contract()
    {
        return $this->hasOne(Contract::class, 'service_request_id', 'id');
    }
    public function sampleContract()
    {
        return $this->hasOne(SampleContract::class, 'id', 'sample_contract_id');

    }
}
