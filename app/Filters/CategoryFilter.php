<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter extends Filter
{

    protected function name(string $value): Builder
    {
        return $this->builder->where('name', 'like', '%' . $value . '%');
    }

    protected function group(int $value): Builder
    {
        return $this->builder->where('category_group_id', $value);
    }

    protected function isPersonal(bool $value): Builder
    {
        return $this->builder->where('is_personal', $value);
    }
}
