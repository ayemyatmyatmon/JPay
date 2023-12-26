@extends('frontend.layouts.app_plain')
@section('title','Profile')
@section('content')
<div class="body_content">
   <div class="profile_img">
      <img src="https://ui-avatars.com/api/?name={{$user->name}}"/>
   </div>
   <div class="profile">
         <div class="card col-md-6">
            <div class="profile_content">
               <div class="p-2">
                  <span class="line">Name</span>
                  <span>{{$user->name}}</span>
               </div>
               <hr class="line"></hr>
               <div class="p-2">
                  <span class="line">Email</span>
                  <span>{{$user->email}}</span>
               </div>
               <hr class="line"></hr>
               <div class="p-2">
                  <span class="line">Phone Number</span>
                  <span>{{$user->phone_number}}</span>
               </div>
               <hr class="line"></hr>
   
                  <a href="{{route('change_password')}}" class="p-2 change_password">
                     <span class="line">Change Password</span>
                     <span><i class="fa-solid fa-unlock"></i></span>
                  </a>
                
               <hr class="line"></hr>
   
               <div class="p-2 logout">
                  <span class="line">LogOut</span>
                  <span><i class="fa-solid fa-right-from-bracket"></i></span>
               </div>
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