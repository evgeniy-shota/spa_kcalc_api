<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\FavoriteProduct;
use App\Models\HiddenProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductUpdateController extends Controller
{
    protected const NOT_AVAILABLE_FOR_NON_ADMIN = ['is_enabled', 'is_personal', 'user_id',];
    protected const NOT_AVAILABLE_FOR_MASS_ASSIGNMENT = ['is_favorite', 'is_hidden'];

    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $request, string $id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return response()->json(['message' => 'Bad request'], 400);
        }
        $validated = $request->validated();
        $product = Product::find($id);

        if (!isset($product)) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $isFavorite = $validated['is_favorite'] ?? null;
        $isHidden = $validated['is_hidden'] ?? null;
        unset(
            $validated['is_favorite'],
            $validated['is_hidden']
        );

        if (isset($isFavorite)) {
            $isFavoriteData = FavoriteProduct::where('user_id', Auth::user()->id)->where('product_id', $product->id)->first();

            if ($isFavorite === true && !isset($isFavoriteData)) {
                FavoriteProduct::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                ]);
            }

            if ($isFavorite === false && isset($isFavoriteData)) {
                $isFavoriteData->delete();
            }
        }

        if (isset($isHidden)) {
            $isHiddenData = HiddenProduct::where('user_id', Auth::user()->id)->where('product_id', $product->id)->first();

            if ($isHidden === true && !isset($isHiddenData)) {
                HiddenProduct::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                ]);
            }

            if ($isHidden === false && isset($isHiddenData)) {
                $isHiddenData->delete();
            }
        }

        if (
            Auth::user()->is_admin ||
            ($product->is_enabled && $product->is_personal && ($product->user_id === Auth::user()->id))
        ) {
            $notAvailableFilds = self::NOT_AVAILABLE_FOR_MASS_ASSIGNMENT;

            if (Auth::user()->is_admin !== true) {
                $notAvailableFilds = array_merge($notAvailableFilds, self::NOT_AVAILABLE_FOR_NON_ADMIN);
            }
            $validated = array_filter($validated, function ($value, $key) use ($notAvailableFilds) {
                if (in_array($key, $notAvailableFilds)) {
                    return false;
                }
                return isset($value);
            }, ARRAY_FILTER_USE_BOTH);

            $product->update($validated);
            $product->is_favorite = $isFavorite;
            $product->is_hidden = $isHidden;
            return new ProductResource($product);
        }
        return response()->json(['message' => 'You do not have permission to update this resource'], 400);
    }
}
