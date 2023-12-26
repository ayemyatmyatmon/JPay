<?php
namespace App\Helpers;

class Response{

    public static function success($data=[]){
       return response()->json([
        'status'=>200,
        'message'=>'Success',
        'data'=>$data
        ]);
    }

    public static function error($code=422,$message,$data){
       return response()->json([
        'status'=>$code,
        'message'=>$message,
        'data'=>$data
        ]);
    }
}

?>