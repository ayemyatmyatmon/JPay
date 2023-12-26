<?php

namespace App\Http\Controllers\Api;
use App\Helpers\Generate;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|unique:users,phone_number',
            'password' => 'required',
        ]);

        $user = new User;
        $user = $user->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        Wallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'account_number' => Generate::accountNumber(),
                'amount' => 0,
            ]
        );
        $token = $user->createToken('JPay')->accessToken;
        return Response::success(["token"=>$token]);
    }

    public function login(Request $request){
        $request->validate([
            'phone_number' => ['required','string'],
            'password' => 'required',
        ]);

        if(Auth::attempt(['phone_number'=>$request->phone_number,'password'=>$request->password])){
            $user=auth()->user();
            $token=$user->createToken('JPay')->accessToken;
            return Response::success(["token"=>$token]);
        }
        return Response::error(400,'Error',null);

    }
}
