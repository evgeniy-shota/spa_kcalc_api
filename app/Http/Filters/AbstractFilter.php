<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter implements FilterInterface
{
    private $queryParam = [];

    public function __construct(array $queryParam)
    {
        $this->queryParam = $queryParam;
    }

    abstract protected function getCallbacks(): array;

    public function apply(Builder $builder)
    {
        $this->before($builder);

        foreach ($this->getCallbacks() as $name => $callback) {
            if (isset($this->queryParam[$name])) {
                call_user_func($callback, $builder, $this->queryParam[$name]);
            }
        }
    }

    protected function before(Builder $builder) {}
}
