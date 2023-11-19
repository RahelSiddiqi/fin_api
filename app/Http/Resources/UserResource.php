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
        $data = [
            "id"        => $this->id,
            "name"      => $this->name,
            "email"     => $this->email,
            "is_admin"  => $this->is_admin,
            "since"     => $this->created_at->format('d M, Y'),
        ];

        if ($this->relationLoaded('transactions')) {
            $data['transaction'] = TransactionResource::collection($this->transactions);
        }

        return $data;
    }
}
