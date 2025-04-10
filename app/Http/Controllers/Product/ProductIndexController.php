<?php

namespace App\Http\Controllers\Product;

use App\Enums\ProductSortParams;
use App\Http\Controllers\Controller;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\Product\IndexRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Sorters\ProductSorter;
use App\Models\Product;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductIndexController extends Controller
{
    protected const NOT_AVAILABLE_FILTERS_FOR_NON_AUTHORIZED = ['isPersonal', 'isFavorite', 'isHidden',];
    protected const NOT_AVAILABLE_FILTERS_FOR_NON_ADMIN = ['isEnabled', 'userId'];
    protected const FILTER_PARAMETERS_CAN_BE_NULL = ['isPersonal', 'isFavorite', 'isHidden', 'isAbstract'];
    protected const NOT_AVAILABLE_SORT_TYPES_FOR_NON_AUTHORIZED = [
        ProductSortParams::PersonalAsc->name,
        ProductSortParams::PersonalDesc->name,
        ProductSortParams::FavoriteAsc->name,
        ProductSortParams::FavoriteDesc->name,
    ];
    /**
     * Handle the incoming request.
     */
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        $notAvailableFilters = null;
        $availableSortTypes = array_flip(array_column(ProductSortParams::cases(), 'name'));

        if (Auth::user() === null) {
            $notAvailableFilters = array_merge(self::NOT_AVAILABLE_FILTERS_FOR_NON_ADMIN, self::NOT_AVAILABLE_FILTERS_FOR_NON_AUTHORIZED);
            $availableSortTypes = array_filter(
                $availableSortTypes,
                fn($key) => !in_array($key, self::NOT_AVAILABLE_SORT_TYPES_FOR_NON_AUTHORIZED),
                ARRAY_FILTER_USE_KEY
            );
        } else if (Auth::user()->is_admin !== true) {
            $notAvailableFilters = self::NOT_AVAILABLE_FILTERS_FOR_NON_ADMIN;
        }

        $validated = array_filter($validated, function ($item, $key) use ($notAvailableFilters) {
            if ($notAvailableFilters && in_array($key, $notAvailableFilters)) {
                return false;
            }
            return $item !== null;
        }, ARRAY_FILTER_USE_BOTH);
        $enabledValue = Auth::user() && Auth::user()->is_admin && isset($validated['isEnabled']) ? $validated['isEnabled'] : true;
        $products = Product::whereEnabled($enabledValue);

        if (Auth::user()) {
            if (Auth::user()->is_admin !== true) {
                $products = $products->leftJoin('favorite_products', function (JoinClause $join) {
                    $join->on('products.id', 'favorite_products.product_id')->where('favorite_products.user_id', Auth::user()->id);
                });
                $products = $products->leftJoin('hidden_products', function (JoinClause $join) {
                    $join->on('products.id', 'hidden_products.product_id')->where('hidden_products.user_id', Auth::user()->id);
                });
                $products = $products->whereAvailable(Auth::user()->id, 'products');
                $products = $products->select('products.*');
                $products = $products->selectRaw('CASE WHEN favorite_products.product_id is not null THEN true ELSE false END is_favorite');
                $products = $products->selectRaw('CASE WHEN hidden_products.product_id is not null THEN true ELSE false END is_hidden');
            }
        } else {
            $products = $products->whereAvailable();
        }

        if (isset($validated['sort'])) {
            if (isset($availableSortTypes[$validated['sort']])) {
                $sorter = app()->make(ProductSorter::class, ['queryParams' => $validated['sort']]);
                $products = $products->sorter($sorter);
            }
            unset($validated['sort']);
        }

        // dump($validated);
        if (count($validated) > 0) {
            $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($validated, function ($val, $key) {
                //  'is_personal', 'is_abstract'
                if (in_array($key, self::FILTER_PARAMETERS_CAN_BE_NULL)) {
                    return true;
                };
                return !empty($val);
            }, ARRAY_FILTER_USE_BOTH)]);
            $products = $products->filter($filter);
        }

        $products =  $products->cursorPaginate();
        // dd($products =  $products->ddRawSql());
        // $products = Product::whereEnabled()->whereAvailable($user_id)->filter($filter)->sorter($sorter)->cursorPaginate();
        return new ProductCollection($products);
    }
}
