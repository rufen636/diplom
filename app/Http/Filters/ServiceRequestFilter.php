<?php

namespace App\Http\Filters;



use Illuminate\Database\Eloquent\Builder;

class ServiceRequestFilter extends AbstractFilter

{
    protected array $keys = [
        'search',
        'status'
    ];
    public function search(Builder $builder, $value) // Переименовал с name на search
    {
        return $builder->where(function($q) use ($value) {
            $q->where('title', 'like', "%$value%")
                ->orWhereHas('providerClient', function ($query) use ($value) {
                    $query->where('name', 'like', "%$value%");
                });
        });
    }

    public function status(Builder $builder, $value)
    {
        return $builder->where('status', $value);
    }
}
