@extends('frontend.layouts.app_plain')
@section('title','Scan & Pay')
@section('content')
<div class="body_content">

    <div class="receive_qr">
        <div class="col-6">
            @if ($errors->any())
            @error('fail')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{$message}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror
            @endif
            <div class="card p-4 d-flex align-items-center justify-content-center">
                <img src="{{asset('img/scan.png')}}" style="width:18rem" class="mt-4" />
                <div class="mt-5">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#scanModal">
                        Scan
                    </button>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">QR Scan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <video id="scanner" width="100%" heigth="160px"></video>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('fronted/js/qr-scanner.umd.min.js')}}"></script>
<script>
    var videoElem = document.getElementById('scanner');

    const qrScanner = new QrScanner(videoElem,function(result){
        if(result){
                qrScanner.stop();
                $('#scanModal').modal('hide');
                window.location.replace(`scan_pay_form?to_phone=${result}`)
              
            }
    });

    $('#scanModal').on('shown.bs.modal', function (event) {
            qrScanner.start();
    });
    $('#scanModal').on('hidden.bs.modal', function (event) {
            qrScanner.stop();
    });
</script>
@endsection