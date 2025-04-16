<?php

namespace App\Http\Requests\Traits;

trait ValidateArray
{
    protected function validateArray(
        array $data,
        int $minCount,
        int $maxCount,
        callable $fnForValidate
    ): array|null {

        if (!isset($data) || count($data) < $minCount || count($data) > $maxCount) {
            return null;
        }

        for ($i = 0, $size = count($data); $i < $size; $i++) {
            $item = $fnForValidate($data[$i]);

            if ($item === null || (!is_bool($item)) && $item === false) {
                return null;
            }
        }

        return $data;
    }
}
