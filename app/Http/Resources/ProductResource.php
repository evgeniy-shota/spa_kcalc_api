<?php

namespace App\Http\Resources;

use App\Models\FavoriteProduct;
use App\Models\HiddenProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currentRout = $request->route()->getName();
        $isFavorite = $this->is_favorite ?? null;
        $isHidden = $this->is_hidden ?? null;

        if (Auth::user()) {

            if (!isset($isFavorite)) {
                $isFavorite = FavoriteProduct::where('user_id', Auth::user()->id)
                    ->where('product_id', $this->id)->first() ? true : false;
            }

            if (!isset($isHidden)) {
                $isHidden = HiddenProduct::where('user_id', Auth::user()->id)
                    ->where('product_id', $this->id)->first() ? true : false;
            }
        }

        // if (in_array($currentRout, ['products.index', 'categories.show', 'search'])) {

        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'name' =>  $this->name,
            'type_id' => $this->type_id,
            'is_personal' => $this->is_personal,
            'is_abstract' => $this->is_abstract,
            'condition' => $this->condition,
            'state' => $this->state,
            'manufacturer' => $this->manufacturer,
            'country_of_manufacture' => $this->country_of_manufacture,
            'quantity' => $this->quantity ?? 100,
            'quantity_to_calculate' => $this->quantity_to_calculate,
            'kcalory_per_unit' => $this->kcalory_per_unit,
            'proteins_per_unit' => $this->proteins_per_unit,
            'carbohydrates_per_unit' => $this->carbohydrates_per_unit,
            'fats_per_unit' => $this->fats_per_unit,
            'kcalory' => $this->kcalory,
            'proteins' => $this->proteins,
            'carbohydrates' =>  $this->carbohydrates,
            'fats' => $this->fats,
            'is_favorite' => $isFavorite,
            'is_hidden' => $isHidden,

            $this->mergeWhen(
                !in_array($currentRout, ['products.index', 'categories.show', 'search']),
                [
                    'trademark_id' => $this->trademark_id,
                    'description' => $this->description,
                    'units' => $this->units,
                    'composition' => $this->product_composition,
                    'thumbnail_image_name' => $this->thumbnail_image_name,
                    'data_source' => $this->data_source,
                    'nutrientAndVitamines' => $this->nutrients_and_vitamins ?
                        json_decode($this->nutrients_and_vitamins, JSON_UNESCAPED_UNICODE) :
                        null,
                    'type' => 'product',
                ]
            ),
        ];


        // return [
        //     'id' => $this->id,
        //     'type_id' => $this->type_id,
        //     'is_personal' => $this->is_personal,
        //     'is_abstract' => $this->is_abstract,
        //     'condition' => $this->condition,
        //     'state' => $this->state,
        //     'category_id' => $this->category_id,
        //     'name' => $this->name,
        //     'manufacturer' => $this->manufacturer,
        //     'country_of_manufacture' => $this->country_of_manufacture,
        //     'trademark_id' => $this->trademark_id,
        //     'description' => $this->description,
        //     'units' => $this->units,
        //     'quantity_to_calculate' => $this->quantity_to_calculate,
        //     'quantity' => $this->quantity,
        //     'composition' => $this->product_composition,
        //     'kcalory' => $this->kcalory,
        //     'proteins' => $this->proteins,
        //     'carbohydrates' => $this->carbohydrates,
        //     'fats' => $this->fats,
        //     'kcalory_per_unit' => $this->kcalory_per_unit,
        //     'proteins_per_unit' => $this->proteins_per_unit,
        //     'carbohydrates_per_unit' => $this->carbohydrates_per_unit,
        //     'fats_per_unit' => $this->fats_per_unit,
        //     'thumbnail_image_name' => $this->thumbnail_image_name,
        //     'data_source' => $this->data_source,
        //     'nutrientAndVitamines' => $this->nutrients_and_vitamins ?
        //         json_decode($this->nutrients_and_vitamins, JSON_UNESCAPED_UNICODE) :
        //         null,

        //     'type' => 'product',
        //     'is_favorite' => $isFavorite,
        //     'is_hidden' => $isHidden,
        // ];
    }
}
