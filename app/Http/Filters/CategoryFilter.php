<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter extends AbstractFilter
{

    public const NAME = 'name';
    public const IS_PERSONAL = 'isPersonal';

    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::IS_PERSONAL => [$this, 'isPersonal'],
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', '%' . $value . '%');
    }

    public function isPersonal(Builder $builder, $value)
    {
        $builder->where('is_personal', $value);
    }
}
