<?php

namespace App\Enums;

enum ProductCondition: string
{
    case solid = 'solid';
    case liquid = 'liquid';
    case semiLiquid = 'semi-liquid';
    case bulk = 'bulk';
}
