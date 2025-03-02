<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{

    public const NAME = 'name';
    public const CATEGORY_ID = 'category_id';
    public const IS_PERSONAL = 'is_personal';
    public const IS_ABSTRACT = 'is_abstract';
    public const MANUFACTURER = 'manufacturer';
    public const COUNTRY_OF_MANUFACTURE = 'country_of_manufacture';
    public const QUANTITY = 'quantity';
    public const KCALORY = 'kcalory';
    public const PROTEINS = 'proteins';
    public const CARBOHYDRATES = 'carbohydrates';
    public const FATS = 'fats';

    public function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::CATEGORY_ID => [$this, 'categoryId'],
            self::IS_PERSONAL => [$this, 'isPersonal'],
            self::IS_ABSTRACT => [$this, 'isAbstract'],
            self::MANUFACTURER => [$this, 'manufacturer'],
            self::COUNTRY_OF_MANUFACTURE => [$this, 'countryOfManufacture'],
            self::QUANTITY => [$this, 'quantity'],
            self::KCALORY => [$this, 'kcalory'],
            self::PROTEINS => [$this, 'proteins'],
            self::CARBOHYDRATES => [$this, 'carbohydrates'],
            self::FATS => [$this, 'fats'],
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->whereLike('name', '%' . $value . '%');
    }

    public function categoryId(Builder $builder, $value)
    {
        $builder->where('category_id', $value);
    }

    public function isPersonal(Builder $builder, $value)
    {
        $builder->where('is_personal', $value);
    }

    public function isAbstract(Builder $builder, $value)
    {
        $builder->where('is_abstract', $value);
    }

    public function manufacturer(Builder $builder, $value)
    {
        $builder->whereLike('manufacturer', '%' . $value . '%');
    }

    public function countryOfManufacture(Builder $builder, $value)
    {
        $builder->whereLike('country_of_manufacture', '%' . $value . '%');
    }

    public function quantity(Builder $builder, $value)
    {
        $builder->whereBetween('quantity', $value);
    }

    public function kcalory(Builder $builder, $value)
    {
        $builder->whereBetween('kcalory', $value);
    }

    public function proteins(Builder $builder, $value)
    {
        $builder->whereBetween('proteins', $value);
    }

    public function carbohydrates(Builder $builder, $value)
    {
        $builder->whereBetween('carbohydrates', $value);
    }

    public function fats(Builder $builder, $value)
    {
        $builder->whereBetween('fats', $value);
    }
}
