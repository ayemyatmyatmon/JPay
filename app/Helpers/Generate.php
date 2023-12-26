<?php

namespace App\Helpers;
use App\Models\Wallet;

class Generate{
    public static function accountNumber(){
        $account_number=mt_rand(0000000000000000,9999999999999999);
        if(Wallet::where('account_number',$account_number)->exists()){
            self::accountNumber();
        }
        return $account_number;
    }
    public static function transactionId(){
        $trn_id=mt_rand(0000000000000000,9999999999999999);
        if(Wallet::where('account_number',$trn_id)->exists()){
            self::accountNumber();
        }
        return $trn_id;
    }
    public static function referenceNumber(){
        $ref_no='RTR'.mt_rand(0000000000000,9999999999999);
        
        return $ref_no;
    }
}

?>