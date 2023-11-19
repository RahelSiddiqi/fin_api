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
    public function index()
    {
        $users = UserService::all();

        if ($users) {
            return UserResource::collection($users);
        }

        return ResponseService::fail();
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $user = UserService::store($data);

        if ($user) {
            return new UserResource($user);
        }

        return ResponseService::fail();
    }


    public function show(User $user)
    {
        //
    }


    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
