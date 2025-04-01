<?php

namespace App\Http\Controllers;

use App\Enums\ProductSortParams;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\Product\IndexRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Sorters\ProductSorter;
use App\Models\Category;
use App\Models\HiddenProduct;
use App\Models\Product;
use App\Models\UserFavoriteProduct;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        // return response()->json(
        //     Product::all()
        // );
        $validate = $request->validated();

        // if (valida)
        // dd(array_filter($validate, function ($val, $key) {
        //     if (in_array($key, ['is_favorite', 'is_hidden'])) {
        //         return true;
        //     };
        //     return !empty($val);
        // }, ARRAY_FILTER_USE_BOTH));

        $user_id = Auth::user() ? Auth::user()->id : null;
        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($validate, function ($val, $key) {
            //  'is_personal', 'is_abstract'
            if (in_array($key, ['is_favorite', 'is_hidden'])) {
                return true;
            };
            return !empty($val);
        }, ARRAY_FILTER_USE_BOTH)]);

        $sortParams = $request->query('sort');

        $sorter = app()->make(ProductSorter::class, ['queryParams' => $sortParams]);
        // $orderCol = 'id';
        // $orderDirection = 'asc';

        // if ($sortParams) {
        //     switch ($sortParams) {
        //         case ProductSortParams::NameAsc->value:
        //             $orderCol = 'name';
        //             $orderDirection = 'asc';
        //             break;
        //         case ProductSortParams::NameDesc->value:
        //             $orderCol = 'name';
        //             $orderDirection = 'desc';
        //             break;
        //         case ProductSortParams::FavoriteAsc->value:
        //             $orderCol = 'is_favoritre';
        //             $orderDirection = 'asc';
        //             break;
        //         case ProductSortParams::FavoriteDesc->value:
        //             $orderCol = 'is_favoritre';
        //             $orderDirection = 'desc';
        //             break;
        //         case ProductSortParams::PersonalAsc->value:
        //             $orderCol = 'is_personal';
        //             $orderDirection = 'asc';
        //             break;
        //         case ProductSortParams::PersonalDesc->value:
        //             $orderCol = 'is_personal';
        //             $orderDirection = 'desc';
        //             break;
        //         case ProductSortParams::AbstractAsc->value:
        //             $orderCol = 'is_abstract';
        //             $orderDirection = 'asc';
        //             break;
        //         case ProductSortParams::AbstractDesc->value:
        //             $orderCol = 'is_abstract';
        //             $orderDirection = 'desc';
        //             break;
        //         case ProductSortParams::KcaloryAsc->value:
        //             $orderCol = 'kcalory';
        //             $orderDirection = 'asc';
        //             break;
        //         case ProductSortParams::KcaloryDesc->value:
        //             $orderCol = 'kcalory';
        //             $orderDirection = 'desc';
        //             break;
        //         case ProductSortParams::ProteinsAsc->value:
        //             $orderCol = 'proteins';
        //             $orderDirection = 'asc';
        //             break;
        //         case ProductSortParams::ProteinsDesc->value:
        //             $orderCol = 'proteins';
        //             $orderDirection = 'desc';
        //             break;
        //         case ProductSortParams::CarbohydratesAsc->value:
        //             $orderCol = 'carbohydrates';
        //             $orderDirection = 'asc';
        //             break;
        //         case ProductSortParams::CarbohydratesDesc->value:
        //             $orderCol = 'carbohydrates';
        //             $orderDirection = 'desc';
        //             break;
        //         case ProductSortParams::FatsAsc->value:
        //             $orderCol = 'fast';
        //             $orderDirection = 'asc';
        //             break;
        //         case ProductSortParams::FatsDesc->value:
        //             $orderCol = 'fast';
        //             $orderDirection = 'desc';
        //             break;
        //         default:
        //             $orderCol = 'id';
        //             $orderDirection = 'asc';
        //             break;
        //     }
        // }

        // ->orderBy('is_personal', 'desc')
        // $products = Product::whereEnabled()->whereAvailable($user_id)->filter($filter)->orderBy($orderCol, $orderDirection)->cursorPaginate();
        $products = Product::whereEnabled()->whereAvailable($user_id)->filter($filter)->sorter($sorter)->cursorPaginate();

        return new ProductCollection($products);
    }

    public function productsFromCategory(IndexRequest $request, string $category_id)
    {
        if (!Category::find($category_id)->is_enabled) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $validate = $request->validated();
        $user_id = Auth::user() ? Auth::user()->id : null;
        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($validate, function ($val, $key) {
            //  'is_personal', 'is_abstract'
            if (in_array($key, ['is_favorite', 'is_hidden'])) {
                return true;
            };
            return !empty($val);
        }, ARRAY_FILTER_USE_BOTH)]);

        $sortParams = $request->query('sort');
        $sorter = app()->make(ProductSorter::class, ['queryParams' => $sortParams]);

        // ->orderBy('is_personal', 'desc')
        // $products = Product::where('category_id', $category_id)->whereEnabled()->whereAvailable($user_id)->filter($filter)->orderBy('id', 'asc')->cursorPaginate();
        $products = Product::where('category_id', $category_id)->whereEnabled()->whereAvailable($user_id)->filter($filter)->sorter($sorter)->cursorPaginate();

        return new ProductCollection($products);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if ($product && $product->is_enabled) {

            // $user_id = Auth::user() ? Auth::user()->id : null;

            if ($product->is_personal == false || (Auth::user() && $product->user_id == Auth::user()->id)) {
                return new ProductResource($product);
            }

            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json(['message' => 'Not Found'], 404);


        // $product = Product::where('is_visible', true)->where('is_personal', false)->orWhere('user_id', $user_id)->get();

        // return new ProductResource($product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized request...'], 401);
        }

        $validated = $request->validated();

        dd($validated);

        $category = Category::create([
            'name' => $request->category['name'],
            'user_id' => $user->id,
            'description' => $request->category['description'],
            'is_personal' => true,
        ]);

        $nutrAndVit = $request->product['nutrients_and_vitamins'];
        // dump($nutrAndVit);

        $product = Product::create([
            'category_id' => $category['id'],
            'user_id' => $user->id,
            'is_personal' => true,
            'name' => $request->product['name'],
            'description' => $request->product['description'],
            'quantity_to_calculate' => $request->product['quantity'],
            'manufacturer' => $request->product['manufacturer'],
            'country_of_manufacture' => $request->product['country_of_manufacture'],
            'composition' => $request->product['composition'],
            'kcalory' => $request->product['kcalory'],
            'proteins' => $request->product['proteins'],
            'carbohydrates' => $request->product['carbohydrates'],
            'fats' => $request->product['fats'],
            'nutrients_and_vitamins' => count($nutrAndVit) > 0 ? json_encode($nutrAndVit, JSON_UNESCAPED_UNICODE) : null,
        ]);

        // dump($category);
        // dump($product);

        return response()->json([
            'product' => $product,
            'category' => $category,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $validate = $request->validated();
        $excludedForUser = ['is_enabled', 'is_personal', 'user_id'];

        if ($user->is_admin || ($product->is_enabled && $product->user_id === $user->id)) {

            $validateForUser = array_filter($validate, function ($key, $val) use ($excludedForUser) {
                if (array_key_exists($key, $excludedForUser)) {
                    return false;
                }
                return true;
            });

            dd($validateForUser);

            if (array_key_exists('category_id', $validate)) {
                $product->category_id = $validate['category_id'];
            }

            if (array_key_exists('type_id', $validate)) {
                $product->type_id = $validate['type_id'];
            }

            if (array_key_exists('is_abstract', $validate)) {
                $product->is_abstract = $validate['is_abstract'];
            }

            if (array_key_exists('name', $validate)) {
                $product->name = $validate['name'];
            }

            if (array_key_exists('thumbnail_image_name', $validate)) {
                $product->thumbnail_image_name = $validate['thumbnail_image_name'];
            }

            if (array_key_exists('manufacturer', $validate)) {
                $product->manufacturer = $validate['manufacturer'];
            }

            if (array_key_exists('country_of_manufacture', $validate)) {
                $product->country_of_manufacture = $validate['country_of_manufacture'];
            }

            if (array_key_exists('trademark_id', $validate)) {
                $product->trademark_id = $validate['trademark_id'];
            }

            if (array_key_exists('description', $validate)) {
                $product->description = $validate['description'];
            }

            if (array_key_exists('units', $validate)) {
                $product->units = $validate['units'];
            }

            if (array_key_exists('condition', $validate)) {
                $product->condition = $validate['condition'];
            }

            if (array_key_exists('state', $validate)) {
                $product->state = $validate['state'];
            }

            if (array_key_exists('quantity_to_calculate', $validate)) {
                $product->quantity_to_calculate = $validate['quantity_to_calculate'];
            }

            if (array_key_exists('quantity', $validate)) {
                $product->quantity = $validate['quantity'];
            }

            if (array_key_exists('composition', $validate)) {
                $product->composition = $validate['composition'];
            }

            if (array_key_exists('kcalory', $validate)) {
                $product->kcalory = $validate['kcalory'];
            }

            if (array_key_exists('proteins', $validate)) {
                $product->proteins = $validate['proteins'];
            }

            if (array_key_exists('carbohydrates', $validate)) {
                $product->carbohydrates = $validate['carbohydrates'];
            }

            if (array_key_exists('fats', $validate)) {
                $product->fats = $validate['fats'];
            }

            if (array_key_exists('kcalory_per_unit', $validate)) {
                $product->kcalory_per_unit = $validate['kcalory_per_unit'];
            }

            if (array_key_exists('proteins_per_unit', $validate)) {
                $product->proteins_per_unit = $validate['proteins_per_unit'];
            }

            if (array_key_exists('carbohydrates_per_unit', $validate)) {
                $product->carbohydrates_per_unit = $validate['carbohydrates_per_unit'];
            }

            if (array_key_exists('fats_per_unit', $validate)) {
                $product->fats_per_unit = $validate['fats_per_unit'];
            }

            if (array_key_exists('nutrients_and_vitamins', $validate)) {
                $product->nutrients_and_vitamins = $validate['nutrients_and_vitamins'];
            }

            if (array_key_exists('data_source', $validate)) {
                $product->data_source = $validate['data_source'];
            }

            if ($user->is_admin) {
                if (array_key_exists('is_personal', $validate)) {
                    $product->is_personal = $validate['is_personal'];
                }

                if (array_key_exists('is_enabled', $validate)) {
                    $product->is_enabled = $validate['is_enabled'];
                }
            }
            $product->save();
            // return new ProductResource($product);
        }

        if (array_key_exists('is_favorite', $validate)) {
            $favoriteProduct = UserFavoriteProduct::where('user_id', $user->id)->where('product_id', $id)->first();

            if ($validate['is_favorite'] === true) {
                if ($favoriteProduct) {
                    return response()->json(['message' => 'Bad Request'], 400);
                }
                UserFavoriteProduct::create([
                    'user_id' => $user->id,
                    'product_id' => $id,
                ]);
            }

            if ($validate['is_favorite'] === false) {
                if (!$favoriteProduct) {
                    return response()->json(['message' => 'Bad Request'], 400);
                }
                $favoriteProduct->delete();
            }
        }

        if (array_key_exists('is_hidden', $validate)) {
            $hiddenProduct = HiddenProduct::where('user_id', $user->id)->where('product_id', $id)->first();
            if ($validate['is_hidden'] === true) {
                if ($hiddenProduct) {
                    return response()->json(['message' => 'Bad request'], 400);
                }
                HiddenProduct::create([
                    'user_id' => $user->id,
                    'product_id' => $id,
                ]);
            }

            if ($validate['is_hidden'] === false) {
                if (!$hiddenProduct) {
                    return response()->json(['message' => 'Bad request'], 400);
                }
                $hiddenProduct->delete();
            }
        }

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dump('Destroy product' . $id);
    }
}
