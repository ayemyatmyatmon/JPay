<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->type == 1) {
            $amount = ' + ' . number_format($this->amount, 2) . "(ks)";
            $phone = '(****' . substr(optional($this->user)->phone_number, -5) . ")";
            $message = __('transaction.transfer_to') . $phone;
            $icon=asset('img/transfer.png');
        } elseif ($this->type == 2) {
            $amount = '-' . number_format($this->amount, 2) . "(ks)";
            $phone = '(****' . substr(optional($this->source)->phone_number, -5) . ")";
            $message = __('transaction.transfer_to') . $phone;
            $icon=asset('img/transfer.png');

        }
        $date=Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
        return [
            'transaction_id' => $this->transaction_id,
            'message' => $message,
            'amount' => $amount,
            'date'=>$date,
            'icon'=>$icon

        ];
    }
}
