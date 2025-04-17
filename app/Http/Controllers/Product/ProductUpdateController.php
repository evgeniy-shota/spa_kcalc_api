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
        $product = Product::where('id', $id);

        if (Auth::user()->is_admin !== true) {
            $product = $product->whereEnabled()->whereAvailable(Auth::user()->id);
        }

        $product = $product->first();

        if (!isset($product)) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $isFavorite = FavoriteProduct::where('user_id', Auth::user()->id)
            ->where('product_id', $product->id)->first();
        $isHidden = HiddenProduct::where('user_id', Auth::user()->id)
            ->where('product_id', $product->id)->first();

        if (isset($validated['is_favorite'])) {

            if ($validated['is_favorite'] === true && !isset($isFavorite)) {
                $isFavorite = FavoriteProduct::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                ]);
            } else if ($validated['is_favorite'] === false && isset($isFavorite)) {
                $isFavorite->delete();
                $isFavorite = null;
            }

            unset($validated['is_favorite'],);
        }

        if (isset($validated['is_hidden'])) {

            if ($validated['is_hidden'] === true && !isset($isHidden)) {
                $isHidden = HiddenProduct::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                ]);
            } else if ($validated['is_hidden'] === false && isset($isHidden)) {
                $isHidden->delete();
                $isHidden = null;
            }

            unset($validated['is_hidden']);
        }

        $notAvailableFilds = self::NOT_AVAILABLE_FOR_MASS_ASSIGNMENT;

        if (Auth::user()->is_admin !== true) {

            if (count($validated) === 0) {
                $product->is_favorite = $isFavorite !== null ? true : false;
                $product->is_hidden = $isHidden !== null ? true : false;
                return new ProductResource($product);
            }

            if (
                ($product->is_personal !== true ||
                    ($product->is_personal === true &&
                        $product->user_id !== Auth::user()->id))
            ) {
                return response()->json(
                    ['message' => 'You do not have permission to update this resource'],
                    400
                );
            }

            $notAvailableFilds = array_merge($notAvailableFilds, self::NOT_AVAILABLE_FOR_NON_ADMIN);
        }

        $validated = array_filter($validated, function ($value, $key) use ($notAvailableFilds) {
            if (in_array($key, $notAvailableFilds)) {
                return false;
            }
            return isset($value);
        }, ARRAY_FILTER_USE_BOTH);

        $product->update($validated);
        $product->is_favorite = $isFavorite !== null ? true : false;
        $product->is_hidden = $isHidden !== null ? true : false;
        return new ProductResource($product);
    }
}
