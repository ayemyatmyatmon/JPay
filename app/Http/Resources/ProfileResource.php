<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $amount = $this->wallet ? $this->wallet->amount : 0;
        $account_number = $this->wallet ? $this->wallet->account_number : '-';
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'amount' => number_format($amount, 2) . "ks",
            'account_number' => $account_number,
        ];

    }
}
