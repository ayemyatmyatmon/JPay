<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="{{asset('fronted/css/style.css')}}" rel="stylesheet" />
    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- DateRange -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

</head>

<body class="font-sans antialiased" x-data="{darkMode: false}" :class="{'dark': darkMode === true }"
    class="antialiased">
    <div class="main_content bg-gray-300">
        {{-- Start Header --}}
        <div class="header_bar">
            <div class="col-8">
                <div class="row">
                    <div class="col-4 text-center pt-3 back_btn">
                        @if(!request()->is('/'))
                        <i class="fa-solid fa-angle-left"></i>
                        @endif
                    </div>
                    <div class="col-4 text-center pt-3">
                        <p>@yield('title')</p>
                    </div>
                    <div class="col-4 text-center pt-3">
                        <a class="notification" href="{{route('notification')}}">
                            <i class="fa-solid fa-bell"></i>
                            @if($unread_noti_count ==0)
                                
                            @else
                            <div style="background: red;border-radius: 100%;display: inline;position: fixed;top: 5px;
                                width: 20px;color:#fff;height: 20px;margin-left:-10px;">{{$unread_noti_count}}</div>
                        
                            @endif
                        </a>

                    </div>

                </div>
            </div>

        </div>
        {{-- End Header --}}

        <!-- Page Content -->
        <main>
            <div class="main_content">
                <div class="body_content">
                    @yield('content')

                </div>
            </div>
        </main>
        {{-- End Page Content --}}

        {{-- Start Bottom --}}
        <div class="bottom_bar">
            <div class="col col-sm-11 col-md-8">
                <a href="{{route('scan_qr')}}">
                    <div class="bottom_qr_parent">
                        <div class="bottom_qr"><img src="{{asset('img/qr-code-scan.png')}}"
                                style="width:20px;height:20px;" /></div>
                    </div>
                </a>

                <div class="row">
                    <div class="col col-sm-3 col-md-3  text-center ">
                        <a href="{{route('home')}}" class="@if(request()->is('/')) active @endif">
                            <i class="fa-solid fa-house"></i>
                            <p>Home</p>
                        </a>
                    </div>
                    <div class="col col-sm-3 col-md-3 text-center">
                        <a href="{{route('wallet')}}" class="@if(request()->is('wallet')) active @endif">
                            <i class="fa-solid fa-wallet"></i>
                            <p>Wallet</p>
                        </a>
                    </div>
                    <div class="col col-sm-3 col-md-3 text-center">
                        <a href="{{route('transaction')}}" class="@if(request()->is('transaction')) active @endif">
                            <i class="fa-solid fa-arrows"></i>
                            <p>Transaction</p>
                        </a>
                    </div>
                    <div class="col col-sm-3 col-md-3 text-center ">
                        <a href="{{route('account_profile')}}"
                            class="@if(request()->is('account_profile')) active @endif">
                            <i class="fa-solid fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        {{-- End Bottom --}}
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js "></script>

    {{-- DateRange --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function(){
            $('.back_btn').on('click',function(e){
                e.preventDefault();
                window.history.back();
            })
            let token = document.querySelector('meta[name="csrf-token"]').content;
            if(token){
                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':token
                    }
                })
            }

            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
                });
                @if(session('success'))
                Toast.fire({
                icon: "success",
                title: "{{session('success')}}"
                });
                @endif
        })
    </script>
    @yield('scripts')
</body>

</html>