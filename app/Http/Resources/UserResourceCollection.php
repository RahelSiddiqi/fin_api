<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ['data' => $this->collection];

        // dd($this->collection);
        // $data = $this->collection->map(function ($data) {
        //     dd($data);
        //     return (new UserResource($data))->resolve();
        // })->toArray();

        // dd($data);
        // return $data;

    }
}
