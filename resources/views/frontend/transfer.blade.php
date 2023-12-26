@extends('frontend.layouts.app_plain')
@section('title','Transfer')
@section('content')
<div class="body_content">
   <div class="profile_img">
      <img src="https://ui-avatars.com/api/?name={{$user->name}}" />
   </div>
   <div class="d-flex justify-content-center">
      <div class="pt-3">
         <p style="margin:0px;">{{$user->name}}</p>
         <p>{{number_format(optional($user->wallet)->amount,2)}} Ks</p>
      </div>
   </div>
   <div class="change_pass">
      <div class="card col-md-6 p-3">
         @if ($errors->any())
         @error('fail')
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{$message}}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
         @enderror
         @endif
         <form action="{{route('transfer_confirmation')}}" method="POST">
            @csrf
            <div class="form-group">
               <label for="to_phone">To Phone<span class="to_phone_number"></span></label>
               <div class="input-group mb-3">
                  <input type="text" class="form-control to_phone" aria-describedby="button-addon2" name="to_phone" value="{{old('to_phone')}}">
                  <button class="btn btn-secondary to_phone_btn" type="button" id="button-addon2"><i
                        class="fa-solid fa-check"></i></button>
               </div>
               @error('to_phone')
               <span class="text text-danger">{{ $message }}</span>
               @enderror
            </div>
            <div class="form-group mt-3">
               <label for="amount">Amount</label>
               <input type="number" class="form-control" id="amount" name="amount" value="{{old('amount')}}">
               @error('amount')
               <span class="text text-danger">{{ $message }}</span>
               @enderror
            </div>

            <div class="form-group mt-3">
               <label for="note">Note</label>
               <textarea class="form-control" placeholder="Leave a comment here" id="note" name="note" value="{{old('note')}}"></textarea>
            </div>
            <div class="row">
               <button type="submit" class="btn btn-theme mt-3">Submit</button>
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

         $('.to_phone_btn').on('click',function(){
            var to_phone=$('.to_phone').val();
            $.ajax({
               url:"/check_phone_number?to_phone=" + to_phone,
               method:'GET',
               success:function(res){
                  if(res.message=='fail'){
                     $('.to_phone_number').text("( " + res.data + ")").css('color','red');
                  }
                  if(res.message=='success'){
                     $('.to_phone_number').text("( " + res.data['name'] + ")").css('color','green');

                  }
               }
            })
         });
      })
</script>
@endsection