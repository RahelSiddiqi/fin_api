<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user()->is_admin) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "amount"        => "required|numeric",
            "payer_id"      => "required|exists:users,id",
            "due_on"        => "required|date",
            "vat"           => "required|numeric|min:0|max:100",
            "is_vat_inc"    => "required|boolean",
        ];
    }
}
