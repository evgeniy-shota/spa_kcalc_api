<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryGroupFilter extends AbstractFilter
{

    public const IS_PERSONAL = 'isPersonal';
    public const IS_FAVORITE = 'isFavorit';
    public const IS_HIDDEN = 'isHidden';

    protected function getCallbacks(): array
    {
        return [
            self::IS_PERSONAL => [$this, 'isPersonal'],
            self::IS_FAVORITE => [$this, 'isFavorit'],
            self::IS_HIDDEN => [$this, 'isHidden'],
        ];
    }

    public function isPersonal(Builder $builder, $value)
    {
        $builder->where('is_personal', $value);
    }

    public function isFavorit(Builder $builder, $value)
    {
        $builder->where('is_favorit', $value);
    }

    public function isHidden(Builder $builder, $value)
    {
        $builder->where('is_hidden', $value);
    }
}
