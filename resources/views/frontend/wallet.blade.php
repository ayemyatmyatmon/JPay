@extends('frontend.layouts.app_plain')
@section('title','Wallet')

@section('content')

<div class="body_content">
   <div class="profile_img">
      <img src="https://ui-avatars.com/api/?name={{$user->name}}"/>
   </div>
   <div class="wallet_card">
         <div class="card col-md-6 p-2">
            <div class="wallet_body">
                <div>
                    User Name
                </div>
                <div>
                    {{$user->name}}
                </div>
            </div>
            <div class="wallet_body">
                <div>
                    Account Number
                </div>
                <div>
                    {{$user->wallet ? $user->wallet->account_number : '-'}}
                </div>
            </div>
            <div class="wallet_body">
                <div>
                    Amount
                </div>
                <div>
                    {{$user->wallet ? number_format($user->wallet->amount) : '-'}} <small>MMK</small>
                </div>
            </div>
           
         </div>
     
   </div>
 

</div>
@endsection