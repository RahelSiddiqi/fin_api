<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ResponseService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = UserService::all();

        if ($users) {
            return UserResource::collection($users);
        }

        return ResponseService::fail(
            "something went wrong!!",
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $user = UserService::store($data);

        if ($user) {
            return new UserResource($user);
        }

        return ResponseService::fail(
            "something went wrong!!",
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
