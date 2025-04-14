<?php

namespace App\Http\Filters;

// use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder;

class DbCategoryFilter extends DbAbstractFilter
{
    public const CATEGORY_GROUP_ID = 'categoryGroupId';
    public const CATEGORY_ID = 'categoryId';
    public const IS_PERSONAL = 'isPersonal';
    public const IS_FAVORITE = 'isFavorite';
    public const IS_HIDDEN = 'isHidden';

    protected function getCallbacks(): array
    {
        return [
            self::CATEGORY_GROUP_ID => [$this, 'categoryGroupId'],
            self::CATEGORY_ID => [$this, 'categoryId'],
            self::IS_PERSONAL => [$this, 'isPersonal'],
            self::IS_FAVORITE => [$this, 'isFavorite'],
            self::IS_HIDDEN => [$this, 'isHidden'],
        ];
    }

    public function categoryGroupId(Builder $builder, $value)
    {
        $builder->whereIn('category_group_id', $value);
    }

    public function categoryId(Builder $builder, $value)
    {
        $builder->whereIn('id', $value);
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
