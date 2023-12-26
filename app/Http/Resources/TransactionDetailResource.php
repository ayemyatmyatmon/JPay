<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
{
   
 

    public function toArray(Request $request): array
    {

        if ($this->type == 1) {
            $amount = ' + ' . number_format($this->amount, 2) . "(ks)";
            $phone = '(****' . substr(optional($this->user)->phone_number, -5) . ")";
            $message = __('transaction.transfer_to' ) . optional($this->source)->name . $phone;
            $transaction_type="Receive";
        } elseif ($this->type == 2) {
            $amount = '-' . number_format($this->amount, 2) . "(ks)";
            $phone = '(****' . substr(optional($this->source)->phone_number, -5) . ")";
            $message = __('transaction.transfer_to' ) . optional($this->source)->name.$phone;
            $transaction_type="Transfer";
    
        }
        $transaction_time=Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
        return [
            
            'title_message'=>__('transaction.success_transfer'),
            'icon'=>asset('img/check.png'),
            'amount'=>$amount,
            'transaction_time'=>$transaction_time,
            'transaction_number'=>$this->transaction_id,
            'transfer_type'=>$transaction_type,
            'transfer_text'=>$message,
        ];
    }
}
