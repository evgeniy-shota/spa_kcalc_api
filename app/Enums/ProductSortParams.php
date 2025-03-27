<?php

namespace App\Enums;

enum ProductSortParams: string
{
    case Default = 'default';
    case NameAsc = 'nameAsc';
    case NameDesc = 'nameDesc';
    case FavoriteAsc = 'favoriteAsc';
    case FavoriteDesc = 'favoriteDesc';
    case PersonalAsc = 'personalAsc';
    case PersonalDesc = 'personalDesc';
    case AbstractAsc = 'abstractAsc';
    case AbstractDesc = 'abstractDesc';
    case KcaloryAsc = 'kcaloryAsc';
    case KcaloryDesc = 'kcaloryDesc';
    case ProteinsAsc = 'proteinsAsc';
    case ProteinsDesc = 'proteinsDesc';
    case CarbohydratesAsc = 'carbohydratesAsc';
    case CarbohydratesDesc = 'carbohydratesDesc';
    case FatsAsc = 'fatsAsc';
    case FatsDesc = 'fatsDesc';
}
