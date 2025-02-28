<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter extends AbstractFilter
{

    public const NAME = 'name';
    public const PERSONAL = 'is_personal';

    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::PERSONAL => [$this, 'is_personal'],
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', '%' . $value . '%');
    }

    public function personal(Builder $builder, $value)
    {
        $builder->where('is_personal', $value);
    }
}
