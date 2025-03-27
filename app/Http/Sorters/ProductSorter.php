<?php

namespace App\Http\Sorters;

use App\Enums\ProductSortParams;
use Illuminate\Database\Eloquent\Builder;

class ProductSorter extends AbstractSorter
{
    const DEFAULT = ProductSortParams::Default->value;
    const NAME_ASC = ProductSortParams::NameAsc->value;
    const NAME_DESC = ProductSortParams::NameDesc->value;
    // const FAVORITE_ASC = ProductSortParams::FavoriteAsc->value;
    // const FAVORITE_DESC = ProductSortParams::FavoriteDesc->value;
    // const PERSONAL_ASC = ProductSortParams::PersonalAsc->value;
    // const PERSONAL_DESC = ProductSortParams::PersonalDesc->value;
    const ABSTRACT_ASC = ProductSortParams::AbstractAsc->value;
    const ABSTRACT_DESC = ProductSortParams::AbstractDesc->value;
    const KCALORY_ASC = ProductSortParams::KcaloryAsc->value;
    const KCALORY_DESC = ProductSortParams::KcaloryDesc->value;
    const PROTEINS_ASC = ProductSortParams::ProteinsAsc->value;
    const PROTEINS_DESC = ProductSortParams::ProteinsDesc->value;
    const CARBOHYDRATES_ASC = ProductSortParams::CarbohydratesAsc->value;
    const CARBOHYDRATES_DESC = ProductSortParams::CarbohydratesDesc->value;
    const FATS_ASC = ProductSortParams::FatsAsc->value;
    const FATS_DESC = ProductSortParams::FatsDesc->value;

    function getCallback(): array
    {
        return [
            self::DEFAULT => [$this, ProductSortParams::Default->value],
            self::NAME_ASC => [$this, ProductSortParams::NameAsc->value],
            self::NAME_DESC => [$this, ProductSortParams::NameDesc->value],
            // self::FAVORITE_ASC => [$this, ProductSortParams::FavoriteAsc->value],
            // self::FAVORITE_DESC => [$this, ProductSortParams::FavoriteDesc->value],
            // self::PERSONAL_ASC => [$this, ProductSortParams::PersonalAsc->value],
            // self::PERSONAL_DESC => [$this, ProductSortParams::PersonalDesc->value],
            self::ABSTRACT_ASC => [$this, ProductSortParams::AbstractAsc->value],
            self::ABSTRACT_DESC => [$this, ProductSortParams::AbstractDesc->value],
            self::KCALORY_ASC => [$this, ProductSortParams::KcaloryAsc->value],
            self::KCALORY_DESC => [$this, ProductSortParams::KcaloryDesc->value],
            self::PROTEINS_ASC => [$this, ProductSortParams::ProteinsAsc->value],
            self::PROTEINS_DESC => [$this, ProductSortParams::ProteinsDesc->value],
            self::CARBOHYDRATES_ASC => [$this, ProductSortParams::CarbohydratesAsc->value],
            self::CARBOHYDRATES_DESC => [$this, ProductSortParams::CarbohydratesDesc->value],
            self::FATS_ASC => [$this, ProductSortParams::FatsAsc->value],
            self::FATS_DESC => [$this, ProductSortParams::FatsDesc->value],
        ];
    }

    public function default(Builder $builder)
    {
        $builder->orderBy('id', 'asc');
    }

    public function nameAsc(Builder $builder)
    {
        $builder->orderBy('name', 'asc');
    }

    public function nameDesc(Builder $builder)
    {
        $builder->orderBy('name', 'desc');
    }

    function favoriteAsc(Builder $builder)
    {
        $builder->orderBy('is_favorite', 'asc');
    }

    function favoriteDesc(Builder $builder)
    {
        $builder->orderBy('is_favorite', 'desc');
    }

    function personalAsc(Builder $builder)
    {
        $builder->orderBy('is_personal', 'asc');
    }

    function personalDesc(Builder $builder)
    {
        $builder->orderBy('is_personal', 'desc');
    }

    function abstractAsc(Builder $builder)
    {
        $builder->orderBy('is_abstract', 'asc');
    }

    function abstractDesc(Builder $builder)
    {
        $builder->orderBy('is_abstract', 'desc');
    }

    function kcaloryAsc(Builder $builder)
    {
        $builder->orderBy('kcalory', 'asc');
    }

    function kcaloryDesc(Builder $builder)
    {
        $builder->orderBy('kcalory', 'desc');
    }

    function proteinsAsc(Builder $builder)
    {
        $builder->orderBy('proteins', 'asc');
    }

    function proteinsDesc(Builder $builder)
    {
        $builder->orderBy('proteins', 'desc');
    }

    function carbohydratesAsc(Builder $builder)
    {
        $builder->orderBy('carbohydrates', 'asc');
    }

    function carbohydratesDesc(Builder $builder)
    {
        $builder->orderBy('carbohydrates', 'desc');
    }

    function fatsAsc(Builder $builder)
    {
        $builder->orderBy('fats', 'asc');
    }

    function fatsDesc(Builder $builder)
    {
        $builder->orderBy('fats', 'desc');
    }
}
