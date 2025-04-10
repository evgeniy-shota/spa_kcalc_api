<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\FavoriteProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductStoreController extends Controller
{
    protected const NOT_AVIALABLE_FOR_NON_ADMIN = ['is_personal', 'is_enabled', 'user_id'];
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);
        $notAvailableData = !Auth::user()->is_admin ? self::NOT_AVIALABLE_FOR_NON_ADMIN : [];
        $validated = array_filter($validated, function ($value, $key) use ($notAvailableData) {
            if (in_array($key, $notAvailableData)) {
                return false;
            }
            return isset($value);
        }, ARRAY_FILTER_USE_BOTH);
        $is_favorite = !empty($validated['is_favorite']);
        $quantityToCalculate = $validated['quantity_to_calculate'] ?? 100;
        unset($validated['quantity_to_calculate'], $validated['is_favorite']);

        // dd($validated);
        $product = Product::create(array_merge($validated, [
            'user_id' => Auth::user()->id_admin ? $validated['user_id'] ?? null : Auth::user()->id,
            'is_personal' => Auth::user()->id_admin ? $validated['is_personal'] : true,
            'is_enabled' => Auth::user()->id_admin ? $validated['is_enabled'] : true,
            'is_abstract' => $validated['is_abstract'] ?? true,
            'quantity_to_calculate' => $quantityToCalculate,
            'quantity' => $validated['quantity'] ?? 100,

            'kcalory_per_unit' => round($validated['kcalory'] / $quantityToCalculate, 2),
            'proteins_per_unit' => round($validated['proteins'] / $quantityToCalculate, 2),
            'carbohydrates_per_unit' => round($validated['carbohydrates'] / $quantityToCalculate, 2),
            'fats_per_unit' => round($validated['fats'] / $quantityToCalculate, 2),
            // 'kcalory_per_unit' =>  $validated['kcalory_per_unit'],
            // 'proteins_per_unit' =>  $validated['proteins_per_unit'],
            // 'carbohydrates_per_unit' =>  $validated['carbohydrates_per_unit'],
            // 'fats_per_unit' =>  $validated['fats_per_unit'],
            // 'nutrients_and_vitamins' => $validated['nutrients_and_vitamins'] ?? null,
        ]));

        if ($is_favorite) {
            FavoriteProduct::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
            ]);
            $product->is_favorite = true;
        }
        return new ProductResource($product);
    }
}
