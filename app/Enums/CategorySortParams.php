<?php

namespace App\Enums;

enum CategorySortParams: string
{
    case Default = 'default';
    case NameAsc = 'nameAsc';
    case NameDesc = 'nameDesc';
    case FavoriteAsc = 'favoriteAsc';
    case FavoriteDesc = 'favoriteDesc';
    case PersonalAsc = 'personalAsc';
    case PersonalDesc = 'personalDesc';
}
