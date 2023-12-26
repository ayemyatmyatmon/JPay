@extends('frontend.layouts.app_plain')
@section('title','Transaction Detail')
@section('content')
<div class="body_content">
    <div class="transaction_card">
        <div class="card col-sm-8 col-md-6 p-2 text-center">
            <div class="card-body">
                <div class="pt-3">
                    <img src="{{asset('img/check.png')}}" width="40px" />

                </div>
                <p class="pt-3">{{__('transaction.success_transfer')}}</p>
                @if($transaction->type==1)
                <h3>
                    <span>+</span><span>{{number_format($transaction->amount,2)}}<small>(Ks)</small></span>
                </h3>
                @elseif($transaction->type==2)
                <h3>
                    <span>-</span><span>{{number_format($transaction->amount,2)}}<small>(Ks)</small></span>
                </h3>
                @endif

                <hr class="color:#ddd !important;">
                <div class="d-flex justify-content-between">
                    <div class="text-muted">{{__('transaction.transaction_time')}}</div>
                    <div>{{$transaction->created_at}}</div>
                </div>

                <div class="d-flex justify-content-between pt-3 pb-3">
                    <div class="text-muted">{{__('transaction.transaction_no')}} </div>
                    <div>{{$transaction->transaction_id}}</div>

                </div>
                <div class="d-flex justify-content-between pb-3">
                    <div class="text-muted">
                        Transfer Type
                    </div>
                    @if($transaction->type==1)
                    <div>
                        Receive
                    </div>
                    @elseif($transaction->type==2)
                    <div>
                        Transfer
                    </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between pb-3">
                    
                    <div class="text-muted">
                        @if($transaction->type==1)
                        {{__('transaction.transfer_from')}}

                        @elseif($transaction->type==2)
                        {{__('transaction.transfer_to')}}

                        @endif
                    </div>
                    <div>{{optional($transaction->source)->name}}
                        <p style="margin:0px;text-align:right;">
                            {{"(*****".substr(($transaction->source)->phone_number,-5).")"}}</p>
                    </div>
                </div>

                <div class="d-flex justify-content-between pb-3">
                    <div class="text-muted">{{__('transaction.amount')}}</div>
                    <div>
                        @if($transaction->type==1)
                        <span>+</span><span>{{number_format($transaction->amount,2)}}<small>(Ks)</small></span>
                        @elseif($transaction->type==2)
                        <span>-</span><span>{{number_format($transaction->amount,2)}}<small>(Ks)</small></span>
                        @endif

                    </div>
                </div>

                <div class="d-flex justify-content-between pt-3 pb-3">
                    <div class="text-muted">Note</div>
                    <div>
                        {{$transaction->note}}
                    </div>
                </div>

            </div>
        </div>
        @endsection