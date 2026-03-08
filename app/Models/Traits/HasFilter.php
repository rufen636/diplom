<?php

namespace App\Models\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait HasFilter
{
    public function scopeFilter(Builder $builder,array $data)
    {
        $ClassName = 'App\\Http\\Filters\\'. class_basename($this) . 'Filter';

        if (!class_exists($ClassName)) {
            return response()->json(['error' => 'Класс не найден'], 404);
        }
        return (new $ClassName())->apply( $data,$builder);
    }
}
