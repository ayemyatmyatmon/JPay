@extends('frontend.layouts.app_plain')
@section('title','Notifications')
@section('content')
<div class="body_content">


    <div class="transaction_card">
        <div class="card col-sm-12 col-md-6 p-2">
            @if(count($notifications) > 0)
            @foreach($notifications as $notification)
            <a href="{{url('notification_detail/' .$notification->id)}}">

                <div class="card-body" style="border-bottom:1px solid #ddd;">

                    <div class="row border-bottom-1">
                      <h5>{{$notification->data['title']}}</h5>
                      <p class="mb-0">{{$notification->data['message']}}</p>
                      <p class="text-muted">{{$notification->created_at}}</p>
                    </div>

                </div>
            </a>
            @endforeach
            @else
            <p class="text-center">No notifications</p>
            @endif
            {{ $notifications->links('pagination::bootstrap-5') }}
        </div>

    </div>


</div>

@endsection


@section('scripts')

<script>
    $('#date').daterangepicker({
            "singleDatePicker": true,
            "autoApply": false,
            "autoUpdateInput": false,
            "locale": {
                "format": "YYYY-MM-DD",
            },
    });

    $('#date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD'));
        var date=$('#date').val();
        var type = $('.type').val();
        history.pushState({},'',`?date=${date}&type=${type}`);
        window.location.reload();

    });
    $('#date').on('cancel.daterangepicker', function(ev, picker){
        $('#date').val('');
            var date = $('#date').val();
            var type = $('.type').val();
            history.pushState(null, '', `?date=${date}&type=${type}`);
            window.location.reload();
        });

        $('.type').change(function(){
            var date=$('#date').val();
            var type = $('.type').val();
            history.pushState({},'',`?date=${date}&type=${type}`);
            window.location.reload();
           })
</script>

@endsection