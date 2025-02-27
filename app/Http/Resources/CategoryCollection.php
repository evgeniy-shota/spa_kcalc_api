<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // dd($this->collection);
        return [
            'count' => count($this->collection),
            'data' => $this->collection,
            // 'id' => $this->id,
            // 'name' => $this->name,
            // 'is_visible' =>$this->is_visible,
        ];
    }
}
