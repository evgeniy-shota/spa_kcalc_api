<?php

namespace App\Enums;

enum ProductState: string
{
    case Chilled = 'chilled';
    case Frozen = 'frozen';
    case Fresh = 'fresh';
}
