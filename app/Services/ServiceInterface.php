<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ServiceInterface
{
    /**
     * @param array $data
     */
    public static function all(): Collection | null;

    /**
     * @param array $data
     */
    public static function store(array $data): Model | bool;

    /**
     * @param Model $model
     * @param array $data
     */
    public static function modify(Model $model, array $data);

    /**
     * @param Model $model
     */
    public static function destroy(Model $model);
}
