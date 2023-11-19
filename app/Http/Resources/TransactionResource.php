<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            "id"     => $this->id,
            "amount"     => $this->amount,
            "total_amount"    => $this->total_amount,
            "paid_amount"    => $this->paid_amount,
            "vat"    => $this->vat,
            "is_vat_inc"    => $this->is_vat_inc,
            "payer_id"    => $this->user_id,
            "due_on" => $this->due_on->format('d M, Y'),
            "status" => $this->getStatus()
        ];
        if ($this->relationLoaded('user')) {
            $data["payer"] = $this->getUser();
        }
        if (($this->relationLoaded('payments'))) {
            $data["payments"] = $this->getPayments();
        }

        return $data;
    }

    public function getStatus(): string
    {
        if ($this->due_on->isPast()) {
            if ($this->paid_amount == $this->total_amount) {
                return 'paid';
            }
            return "overdue";
        }
        return 'outstanding';
    }
    public function getUser(): UserResource
    {
        return new UserResource($this->user);
    }
    public function getPayments(): ResourceCollection
    {
        return PaymentResource::collection($this->payments);
    }
}
