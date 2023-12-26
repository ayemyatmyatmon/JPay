@extends('frontend.layouts.app_plain')
@section('title','Transaction')
@section('content')
<div class="body_content">
    <div class="row d-flex justify-content-center">

        <div class="card col-sm-4 col-md-3 p-2">
            <div class="input-group">
                <label class="input-group-text p-1">Date</label>
                <input type="text" id="date" class="form-control " value="{{request()->date}}" placeholder="All">
            </div>
        </div>
        <div class="card col-sm-4 col-md-3 p-2">
            <div class="input-group">
                <label class="input-group-text m-0" for="inputGroupSelect02">Type</label>

                <select class="form-select type" id="inputGroupSelect02">
                    <option value="">All</option>
                    <option value="1" @if(request()->type==1) selected @endif>Income</option>
                    <option value="2" @if(request()->type==2) selected @endif>Expense</option>
                </select>
            </div>
        </div>

    </div>

    <div class="transaction_card">
        <div class="card col-sm-12 col-md-6 p-2">
            @if(count($transactions)>0)
            <div class="infinite-scroll">

            @foreach($transactions as $transaction)
            <a href="{{url('transaction_detail/' .$transaction->transaction_id)}}">

                <div class="card-body" style="border-bottom:1px solid #ddd;">

                    <div class="row border-bottom-1">
                        <div class="col-9">

                            <span class="d-flex">
                                @if($transaction->type==2)
                                <span style="line-height:4;margin-right:6px;"><img src="{{asset('img/transfer.png')}}"
                                        style="width:40px;" /></span>
                                <span>
                                    <p>
                                        {{__('transaction.transfer_to')}}
                                        {{'( *****'.substr(optional($transaction->source)->phone_number,-5) .' )'}}
                                    </p>

                                    <p class="text-muted">{{$transaction->created_at}}</p>
                                </span>


                                @elseif($transaction->type==1)
                                <span style="line-height:4;margin-right:6px;"><img src="{{asset('img/receive.png')}}"
                                        style="width:40px;" /></span>
                                <span>
                                    <p>
                                        {{__('transaction.transfer_from')}}
                                        {{'( *****'.substr(optional($transaction->user)->phone_number,-5) .' )'}}
                                    </p>

                                    <p class="text-muted">{{$transaction->created_at}}</p>
                                </span>
                                @endif
                            </span>
                        </div>
                        <div class="col-3 r-0">
                            @if($transaction->type==2)
                            <span> - <span>
                                    @elseif($transaction->type==1)
                                    <span> + <span>
                                            @endif
                                            {{number_format($transaction->amount,2)}} <small>Ks</small>

                        </div>

                    </div>

                </div>
            </a>
            @endforeach
            {{ $transactions->links('pagination::bootstrap-5') }}

            </div>
            @else
            <p class="text-center">No Transaction</p>
            @endif


        </div>

    </div>
    {{-- <div class="col-6" style="margin:0 auto;">
        {{$transactions->links("pagination::bootstrap-5")}}

    </div> --}}

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