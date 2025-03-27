<?php

namespace App\Http\Sorters;

use Illuminate\Database\Eloquent\Builder;

interface SorterInterface
{
    public function apply(Builder $builder);
}
