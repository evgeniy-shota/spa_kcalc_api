<?php

namespace App\Models\Traits;

use App\Http\Sorters\SorterInterface;
use Illuminate\Database\Eloquent\Builder;

trait Sorterable
{
    public function scopeSorter(Builder $builder, SorterInterface $sorter)
    {
        $sorter->apply($builder);
        return $builder;
    }
}
