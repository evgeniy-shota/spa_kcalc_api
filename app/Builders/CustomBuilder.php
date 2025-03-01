<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class CustomBuilder extends Builder
{

    public function whereEnabled(): self
    {
        return $this->where('is_enabled', true);
    }

    public function whereAvailable($user_id = null): self
    {
        if (isset($user_id)) {
            return $this->where(function (Builder $query) use ($user_id) {
                $query->where('is_personal', false)->orWhere('user_id', $user_id);
            });
        }
        return $this->where('is_personal', false);
    }
}
