@extends('frontend.layouts.app_plain')
@section('title','Receive QR')
@section('content')
<div class="body_content">

    <div class="receive_qr">
        <div class="col-6">
            <div class="card p-4 d-flex align-items-center" >
                <p style="text-align:center">Scan to pay me</p>
                <img style="width:18rem;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->color(171,102,255)->generate($user->phone_number)) !!} ">  
            </div>
        </div>
      
    </div>
</div>
@endsection