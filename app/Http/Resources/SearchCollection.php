<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->collection['products']);

        return [
            'data' => $this->collection,
        ];

        // return [
        //     'data' => [
        //         'products' => $this->collection['products'],
        //         // 'personalProducts' => $this->collection['personalProducts'],
        //         // 'diets' => $this->collection['diets'],
        //     ],
        // ];
    }
}
