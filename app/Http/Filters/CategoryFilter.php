<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter extends AbstractFilter
{

    public const IS_PERSONAL = 'isPersonal';
    public const IS_FAVORITE = 'isFavorite';
    public const IS_HIDDEN = 'isHidden';

    protected function getCallbacks(): array
    {
        return [
            self::IS_PERSONAL => [$this, 'isPersonal'],
            self::IS_FAVORITE => [$this, 'isFavorite'],
            self::IS_HIDDEN => [$this, 'isHidden'],
        ];
    }

    public function isPersonal(Builder $builder, $value)
    {
        $builder->where('is_personal', $value);
    }

    public function isFavorite(Builder $builder, $value)
    {
        $builder->where('is_favorite', $value);
    }

    public function isHidden(Builder $builder, $value)
    {
        $builder->where('is_hidden', $value);
    }
}
