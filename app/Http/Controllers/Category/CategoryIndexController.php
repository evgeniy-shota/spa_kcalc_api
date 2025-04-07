<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Filters\CategoryFilter;
use App\Http\Requests\Category\IndexRequest;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(IndexRequest $request)
    {
        $categories = Category::whereEnabled()->whereAvailable(Auth::user() ? Auth::user()->id : null, 'categories');

        if (Auth::user()) {
            $categories = $categories->leftJoin('favorite_categories', function (JoinClause $join) {
                $join->on('categories.id', 'favorite_categories.category_id')->where('favorite_categories.user_id', Auth::user()->id);
            });
            $categories = $categories->leftJoin('hidden_categories', function (JoinClause $join) {
                $join->on('categories.id', 'hidden_categories.category_id')->where('hidden_categories.user_id', Auth::user()->id);
            });
            $categories = $categories->select('categories.*');
            $categories = $categories->selectRaw('CASE WHEN favorite_categories.category_id is not null THEN true ELSE false END is_favorite');
            $categories = $categories->selectRaw('CASE WHEN hidden_categories.category_id is not null THEN true ELSE false END is_hidden');

            $validated = $request->validated();
            $filter = app()->make(CategoryFilter::class, ['queryParams' => array_filter($validated)]);
            $categories = $categories->filter($filter);
        }
        $categories = $categories->get();
        return new CategoryCollection($categories);
    }
}
