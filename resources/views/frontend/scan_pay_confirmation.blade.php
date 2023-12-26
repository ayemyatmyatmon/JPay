@extends('frontend.layouts.app_plain')
@section('title','Tranfer Confirmation')
@section('content')
<div class="body_content">
   <div class="profile_img">
      <img src="https://ui-avatars.com/api/?name={{$auth_user->name}}" />
   </div>
   <div class="profile">

      <div class="card col-md-6">
         @include('frontend.layouts.flash')
         <form id="form" action="{{ route('scan_pay_complete')}}" method="POST" >
            @csrf
            <input type="hidden" class="form-control"  name="to_phone" value="{{$to_phone}}" />
            <input type="hidden" class="form-control"  name="amount" value="{{$amount}}" />
            <input type="hidden" class="form-control" name="note" value="{{$note}}" />

            <div class="p-3">
               <div class="p-2">
                  <div class="line">From Name</div>
                  <div>{{$auth_user->name}}</div>
               </div>
               <div class="p-2">
                  <div class="line">To({{$to_name}})</div>
                  <div>{{$to_phone}}</div>
               </div>
               <div class="p-2">
                  <div class="line">Amount</div>
                  <div>{{$amount}} <small>MMK</small></div>
               </div>
               <div class="p-2">
                  <div class="line">Note</div>
                  <div>{{$note}}</div>
               </div>
               <div class="row">
                  <button type="submit" class="btn btn-theme password_complete">Confirm</button>

               </div>
            </div>
         </form>

      </div>
   </div>
</div>
@endsection

@section('scripts')
<script>
   $(document).ready(function() {
         $('.password_complete').on('click',function(e){
            e.preventDefault();

            Swal.fire({
                  title: "Please Enter your password",
                  icon: "info",
                  html: `
                     <input type="password" id="swal-input1" name="password" class="form-control text-center check_password" required/>
                  `,
                  showCloseButton: true,
                  showCancelButton: true,
                  reverseButtons:true,
                  didOpen: () => {
                     document.getElementById('swal-input1').focus();
                  },

            }).then((result) => {
                     if (result.isConfirmed) {
                        var password=$('.check_password').val();

                        $.ajax({
                           url:`/check_password?password=${password}`,
                           method:'GET',
                           success:function(res){
                              if(res.message == 'success'){
                                $('#form').submit();
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: res.data,
                                });
                            }
                             
                           }

                           
                        })
                     } else if (result.isDenied) {
                        Swal.fire("Changes are not saved", "", "info");
                     }
                     });

         })
      })
</script>
@endsection