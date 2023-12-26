@extends('frontend.layouts.app_plain')
@section('title','Change Password')
@section('content')
<div class="body_content">
   <div class="profile_img">
      <img src="https://ui-avatars.com/api/?name={{$user->name}}" />
   </div>
   <div class="change_pass">

      <div class="card col-md-6 p-3">
         <div style="text-align:center;">
            <img src="{{asset('img/change_password.svg')}}" width='200px;'/>
         </div>
         @if ($errors->any())
         @error('fail')
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{$message}}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
         @enderror
         @endif
         <form action="{{route('change_password_store')}}" method="POST">
            @csrf
            
            <div class="form-group">
               <label for="old_password">Old Password</label>
               <input type="password" class="form-control" id="old_password" name="old_password">
               @error('old_password')
               <span class="text text-danger ">{{ $message }}</span>
               @enderror
            </div>
          
            <div class="form-group mt-3">
               <label for="new_password">New Password</label>
               <input type="password" class="form-control" id="new_password" name="new_password">
               @error('new_password')
               <span class="text text-danger">{{ $message }}</span>
               @enderror
            </div>
            <div class="row submit mt-3">
               <button type="submit" class="btn btn-theme mt-2">Submit</button>
            </div>
         </form>
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