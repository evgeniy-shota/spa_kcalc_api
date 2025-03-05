<?php

namespace App\Http\Resources;

use App\Models\Product;
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
        // dd($this->additionalData);

        return [
            'data' => $this->collection,
            'count' => count($this->collection),
            'label' => 'Продукты'
        ];

        // return [
        //     'data' => $this->collection,
        //     'count' => count($this->collection),
        //     'label' => 'Продукты'
        // ];
    }

    // public function paginationInformation($request, $paginated, $default)
    // {
    //     // dump($paginated);
    //     $default['links']['prev_cursor'] = $paginated['prev_cursor'];
    //     $default['links']['next_cursor'] = $paginated['next_cursor'];

    //     return $default;
    // }
}
