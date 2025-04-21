<?php

namespace App\Http\Controllers\CategoryGroup;

use App\Http\Controllers\Controller;
use App\Http\Filters\CategoryGroupFilter;
use App\Http\Filters\DbCategoryGroupFilter;
use App\Http\Requests\CategoryGroup\IndexRequest;
use App\Http\Resources\CategoryGroupCollection;
use App\Models\CategoryGroup;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryGroupIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(IndexRequest $request)
    {
        $tableQuery = null;
        $validated = $request->validated();
        $filter = count($validated) > 0 ?
            app()->make(
                DbCategoryGroupFilter::class,
                ['queryParams' => array_filter($validated, function ($value) {
                    return $value !== null;
                })]
            ) : null;

        if (Auth::user()) {
            $tableQuery = function ($query) {
                $query->from('category_groups')
                    ->select('category_groups.*')
                    ->selectRaw(
                        'CASE WHEN favorite_category_groups.category_group_id is not null THEN true ELSE false END as is_favorite'
                    )
                    ->selectRaw(
                        'CASE WHEN hidden_category_groups.category_group_id is not null THEN true ELSE false END as is_hidden'
                    )
                    ->leftjoin('favorite_category_groups', function (JoinClause $join) {
                        $join->on('category_groups.id', 'favorite_category_groups.category_group_id')
                            ->where('favorite_category_groups.user_id', Auth::user()->id);
                    })
                    ->leftjoin('hidden_category_groups', function (JoinClause $join) {
                        $join->on('category_groups.id', 'hidden_category_groups.category_group_id')
                            ->where('hidden_category_groups.user_id', Auth::user()->id);
                    });
            };
        } else {
            $tableQuery = 'category_groups';
        }

        $categoryGroups = DB::table($tableQuery, 'category_groups')
            ->whereEnabled()
            ->whereAvailable(Auth::user() ? Auth::user()->id : null);

        if ($filter !== null) {
            $categoryGroups = $categoryGroups->where(
                function ($query) use ($filter) {
                    $query->filter($query, $filter);
                }
            );
        }

        $categoryGroups = $categoryGroups->get();
        return new CategoryGroupCollection($categoryGroups);
    }
}
