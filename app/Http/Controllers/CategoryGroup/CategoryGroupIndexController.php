<?php

namespace App\Http\Controllers\CategoryGroup;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryGroupCollection;
use App\Models\CategoryGroup;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryGroupIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $categoryGroups = CategoryGroup::whereEnabled()->whereAvailable(Auth::user() ? Auth::user()->id : null, 'category_groups');

        if (Auth::user()) {
            $categoryGroups = $categoryGroups->leftjoin('favorite_category_groups', function (JoinClause $join) {
                $join->on('category_groups.id', 'favorite_category_groups.category_group_id')
                    ->where('favorite_category_groups.user_id', Auth::user()->id);
            });
            $categoryGroups = $categoryGroups->leftjoin('hidden_category_groups', function (JoinClause $join) {
                $join->on('category_groups.id', 'hidden_category_groups.category_group_id')
                    ->where('hidden_category_groups.user_id', Auth::user()->id);
            });
            $categoryGroups = $categoryGroups->select('category_groups.*');
            $categoryGroups = $categoryGroups->selectRaw(
                'CASE WHEN favorite_category_groups.category_group_id is not null THEN true ELSE false END as is_favorite'
            );
            $categoryGroups = $categoryGroups->selectRaw(
                'CASE WHEN hidden_category_groups.category_group_id is not null THEN true ELSE false END as is_hidden'
            );
        }
        $categoryGroups = $categoryGroups->get();
        // $categories = Category::whereEnabled()->whereAvailable(Auth::user() ? Auth::user()->id : null)->groupBy('category_group_id', 'id')->get();
        return new CategoryGroupCollection($categoryGroups);
    }
}
