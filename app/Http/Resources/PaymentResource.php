<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            "id"            => $this->id,
            "amount"        => $this->amount,
            "paid_on"       => $this->paid_on->format('d M, Y'),
            "comment"       => $this->comment,
        ];
        if ($this->relationLoaded('transaction')) {
            $data["transaction"]   = $this->getTransaction();
        }
        return $data;
    }

    public function getTransaction(): TransactionResource
    {
        return new TransactionResource($this->transaction);
    }
}
