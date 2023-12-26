@extends('frontend.layouts.app_plain')
@section('title','Home')
@section('content')
<div class="content">
   <div class="profile_img">
      <img src="https://ui-avatars.com/api/?name={{$user->name}}" />
   </div>
   <div class="home">
      <div class="card col-md-6 p-4">
         <div class="scan_pay_qr mb-2">
            <a href="{{route('scan_qr')}}" class="text-decoration-none text-black" >
               <div class="scan_pay">
                  <span class="mr-3"><img src="{{asset('img/qr-code-scan.png')}}" /></span>
                  <span style="margin-left:13px;">Scan & Pay</span>
               </div>
            </a>
            
            <a href="{{route('receive_qr')}}" class="text-decoration-none text-black" >
               <div class="qr">

                  <span class="mr-5"><img src="{{asset('img/qr.png')}}" /></span>
                  <span style="margin-left:13px;">Receive QR</span>
               </div>
            </a>

         </div>
         <hr>
         </hr>
         <div class="transfer">
            <a href="{{route('transfer')}}">
               <div>
                  Transfer
               </div>
               <div><i class="fa-solid fa-money-bill-transfer"></i></div>

            </a>
         </div>
         <hr>
         </hr>
         <div class="transfer">
            <a href="{{route('transaction')}}">
               <div>
                  Transaction
               </div>
               <div><i class="fa-solid fa-arrow-right-arrow-left"></i></div>

            </a>
         </div>
         <hr>
         </hr>
         <div class="transfer">
            <a href="{{route('wallet')}}">
               <div>
                  Wallet
               </div>
               <div><i class="fa-solid fa-wallet"></i></div>

            </a>
         </div>
      </div>

   </div>
</div>
@endsection