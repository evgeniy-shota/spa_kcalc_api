<?php

namespace App\Utils;

class FilterVar
{
    public static function filterIntFloat($value): int|float|null
    {
        if ($value === null) {
            return null;
        }
        
        $filtered = filter_var($value, FILTER_VALIDATE_INT);

        if ($filtered !== false) {
            return $filtered;
        }

        $filtered = filter_var($value, FILTER_VALIDATE_FLOAT);

        if ($filtered !== false) {
            return $filtered;
        }

        return null;
    }

    public static function filterInt($value): int|null
    {
        if ($value === null) {
            return null;
        }
        
        $filtered = filter_var($value, FILTER_VALIDATE_INT);

        if ($filtered !== false) {
            return $filtered;
        }

        return null;
    }

    public static function filterBool($value): bool|null
    {
        if ($value === null) {
            return null;
        }
        
        return filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);
    }
}
