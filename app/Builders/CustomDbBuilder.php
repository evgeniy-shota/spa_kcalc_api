<?php

namespace App\Builders;

use Illuminate\Database\Query\Builder;
use Laravel\Pail\ValueObjects\Origin\Console;

use App\Models\Traits\DbFilterable;

class CustomDbBuilder extends Builder
{

    use DbFilterable;

    public function whereEnabled($value = true): self
    {
        if ($value === null) {
            return $this;
        }
        return $this->where('is_enabled', $value);
    }

    public function whereAvailable($user_id = null, $tableName = ''): self
    {
        if (isset($user_id)) {
            return $this->where(function (Builder $query) use ($user_id, $tableName) {
                $query->where('is_personal', false)->orWhere(($tableName ? $tableName . '.' : '') . 'user_id', $user_id);
            });
        }
        return $this->where('is_personal', false);
    }
}
