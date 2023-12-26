@if ($errors->has('fail'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{$errors->first('fail')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@endif