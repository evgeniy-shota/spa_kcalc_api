<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // var_dump(count($this->collection))

        return [
            'data' => $this->collection->additional(['short_output' => true]),
            'count' => count($this->collection),
            'label' => 'Продукты'
        ];

        return [
            'data' => $this->collection,
            'count' => count($this->collection),
            'label' => 'Продукты'
        ];
    }
}
