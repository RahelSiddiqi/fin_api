<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name"     => $request->name,
            "email"    => $request->email,
            "is_admin" => $request->is_admin,
            "since"    => $request->created_at->format('d m, Y'),
        ];
    }
}
