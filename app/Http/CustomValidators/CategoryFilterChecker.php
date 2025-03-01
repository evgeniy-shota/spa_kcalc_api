<?php

namespace App\Http\CustomValidators;

class CategoryFilterChecker
{

    protected $params = [];

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function __invoke(): array
    {

        if (array_key_exists('isPersonal', $this->params)) {
            if ($this->params['isPersonal'] === 'true') {
                $this->params['isPersonal'] = true;
            } else if ($this->params['isPersonal'] === 'false') {
                $this->params['isPersonal'] = false;
            }
        }
        return $this->params;
    }
}
