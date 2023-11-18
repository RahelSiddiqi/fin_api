<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserService implements ServiceInterface
{
    /**
     * @param array $data
     */
    public static function all(): Collection | null
    {
        $users = User::all();
        if ($users) {
            return $users;
        }
        return null;
    }
    /**
     * Create new user or fail
     * @param array $data
     * @return Model|bool
     */
    public static function store(array $data): Model | bool
    {
        try {
            $user = User::create(array_merge_recursive([
                'email_verified_at' => now(),
            ], $data));
            return $user;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * @param Model $model
     * @param array $data
     */
    public static function modify(Model $model, array $data)
    {
    }

    /**
     * @param Model $model
     */
    public static function destroy(Model $model)
    {
    }
}
