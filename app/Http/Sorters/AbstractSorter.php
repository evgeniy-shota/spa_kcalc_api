<?php

namespace App\Http\Sorters;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractSorter implements SorterInterface
{
    public function __construct(private $queryParams = '') {}

    abstract protected function getCallback(): array;

    public function apply(Builder $builder)
    {
        $this->before($builder);

        foreach ($this->getCallback() as $name => $callback) {
            if ($this->queryParams === $name) {
                call_user_func($callback, $builder);
            }
        }
    }

    protected function before(Builder $builder) {}
}
