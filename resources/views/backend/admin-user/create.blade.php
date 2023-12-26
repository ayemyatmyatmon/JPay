@extends('backend.layouts.app')
@section('extracss')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" />
<style>
    .dataTables_wrapper .dataTables_length select {
        width: 4rem;
    }
</style>
@endsection
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Create Admin User</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <form action="{{route('admin-user.store')}}" method="POST" id="create">
            @csrf

            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control">
                @if($errors->first('name'))
                <span class="text-danger">{{$errors->first('name')}}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control">
                @if($errors->first('email'))
                <span class="text-danger">{{$errors->first('email')}}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="">Phone Number</label>
                <input type="phone_number" name="phone_number" class="form-control">
                @if($errors->first('phone_number'))
                <span class="text-danger">{{$errors->first('phone_number')}}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control">
                @if($errors->first('name'))
                <span class="text-danger">{{$errors->first('password')}}</span>
                @endif
            </div>

            <div class="d-flex justify-content-center">
                <button class="btn btn-secondary mr-2 back-btn">Cancel</button>
                <button type="submit" class="btn btn-primary">Confirm</button>
            </div>
        </form>
    </div>

</div>

@endsection
@section('scripts')

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){
  
    });
</script>
@endsection