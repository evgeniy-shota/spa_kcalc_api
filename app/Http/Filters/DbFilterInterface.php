<?php

namespace App\Http\Filters;

// use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder;

interface DbFilterInterface
{
    public function apply(Builder $builder);
}
