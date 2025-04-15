<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Filters\CategoryFilter;
use App\Http\Filters\DbCategoryFilter;
use App\Http\Requests\Category\IndexRequest;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(IndexRequest $request)
    {
        // $categories = Category::whereEnabled()->whereAvailable(Auth::user() ? Auth::user()->id : null, 'categories');
        $tableToQuery = null;
        $filter = null;

        if (Auth::user()) {
            $validated = $request->validated();
            $filter = count($validated) > 0 ?
                app()->make(
                    DbCategoryFilter::class,
                    ['queryParams' => array_filter($validated)]
                ) : null;
            // $filter = app()->make(CategoryFilter::class, ['queryParams' => array_filter($validated)]);
            $tableToQuery = function ($query) {
                $query->from('categories')
                    ->select('categories.*')
                    ->selectRaw('CASE WHEN favorite_categories.category_id is not null THEN true ELSE false END is_favorite')
                    ->selectRaw('CASE WHEN hidden_categories.category_id is not null THEN true ELSE false END is_hidden')
                    ->leftJoin('favorite_categories', function (JoinClause $join) {
                        $join->on('categories.id', 'favorite_categories.category_id')->where('favorite_categories.user_id', Auth::user()->id);
                    })
                    ->leftJoin('hidden_categories', function (JoinClause $join) {
                        $join->on('categories.id', 'hidden_categories.category_id')->where('hidden_categories.user_id', Auth::user()->id);
                    });
            };
            // $categories = $categories->select('categories.*');
            // $categories = $categories->selectRaw('CASE WHEN favorite_categories.category_id is not null THEN true ELSE false END as is_favorite');
            // $categories = $categories->selectRaw('CASE WHEN hidden_categories.category_id is not null THEN true ELSE false END as is_hidden');

            // $categories = $categories->leftJoin('favorite_categories', function (JoinClause $join) {
            //     $join->on('categories.id', 'favorite_categories.category_id')->where('favorite_categories.user_id', Auth::user()->id);
            // });
            // $categories = $categories->leftJoin('hidden_categories', function (JoinClause $join) {
            //     $join->on('categories.id', 'hidden_categories.category_id')->where('hidden_categories.user_id', Auth::user()->id);
            // });

            // $validated = $request->validated();
            // $filter = app()->make(CategoryFilter::class, ['queryParams' => array_filter($validated)]);
            // $categories = $categories->filter($filter);
        } else {
            $tableToQuery = 'categories';
        }

        $categories = DB::table($tableToQuery, 'categories')->whereEnabled()->whereAvailable(Auth::user() ? Auth::user()->id : null);

        if ($filter !== null) {
            $categories = $categories->where(function ($query) use ($filter) {
                $query->filter($query, $filter);
            });
        }

        $categories = $categories->get();
        return new CategoryCollection($categories);
    }
}
