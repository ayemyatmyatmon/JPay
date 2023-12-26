@extends('frontend.layouts.app_plain')
@section('title','Change Password')
@section('content')
<div class="body_content">
  
   <div class="change_pass">

      <div class="card col-md-6 p-3">
         <div style="text-align:center;">
            <img src="{{asset('img/notifications.png')}}" width='200px;'/>
         </div>
         <div style="text-align:center;">
            <h4>{{$notification->data['title']}}</h4>
            <p class="mb-0">{{$notification->data['message']}}</p>
            <p class="text-muted">{{$notification->created_at}}</p>
         </div>
         <div class="text-center">
            <a href="{{$notification->data['web_link']}}" class="btn btn-theme btn-sm">Continue</a>

         </div>
      </div>

   </div>
</div>
@endsection

@section('scripts')
<script>
   $(document).ready(function() {
         $('.logout').on('click',function(){
            Swal.fire({
            title: "Are you sure you want to logout?",
            showCancelButton:true,
            reverseButtons:true,
            confirmButtonText: "Yes",
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
               $.ajax({
                  url:"{{route('logout')}}",
                  method:'POST',
               });
               window.location.reload();

            } 
            });
         })
      })
</script>
@endsection