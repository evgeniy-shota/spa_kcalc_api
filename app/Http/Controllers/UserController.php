<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Profile;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = Auth::user();
        // dd($currentUser);
        return new UserResource($currentUser);
        // return response()->json(Auth::user(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();

        if (!isset($user) || $user->id != $id) {
            dump($user->id);
            dump($id);
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // dump($request);

        Profile::where('user_id', $user->id)->update([
            'gender' => $request->gender,
            'date_of_birth' => $request->dateOfBirth,
            'height' => $request->height,
            'level_of_training' => $request->level_of_training,
            'level_of_daily_activity' => $request->level_of_daily_activity,
            'weight' => $request->weight,
            'target_weight' => $request->target_weight,
        ]);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
