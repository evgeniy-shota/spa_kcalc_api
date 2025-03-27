<?php

namespace App\Enums;

enum CategoryGroupSortParams: string
{
    case Default = 'default';
    case NameAsc = 'nameAsc';
    case NameDesc = 'nameDesc';
    case FavoriteAsc = 'favoriteAsc';
    case FavoriteDesc = 'favoriteDesc';
}
