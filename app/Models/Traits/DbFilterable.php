<?php

namespace App\Models\Traits;

// use App\Http\Filters\FilterInterface;
use App\Http\Filters\DbFilterInterface;
// use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder;

trait DbFilterable
{
    public function filter(Builder $builder, DbFilterInterface $DbFilter)
    {
        $DbFilter->apply($builder);

        return $builder;
    }
}
