<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0;
            background-color: #F0F3F8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow-y: hidden;

            /* background-image: url("{{ asset('admin/dist/images/meeting-room.jpg') }}"); */
        }

        a {
            background-color: transparent
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }


        .button {
            border-top: 1px solid #96d1f8;
            background: #65a9d7;
            background: -webkit-gradient(linear, left top, left bottom, from(#3e779d), to(#65a9d7));
            background: -webkit-linear-gradient(top, #3e779d, #65a9d7);
            background: -moz-linear-gradient(top, #3e779d, #65a9d7);
            background: -ms-linear-gradient(top, #3e779d, #65a9d7);
            background: -o-linear-gradient(top, #3e779d, #65a9d7);
            padding: 20px 40px;
            -webkit-border-radius: 0px;
            -moz-border-radius: 0px;
            border-radius: 0px;
            -webkit-box-shadow: rgba(0, 0, 0, 1) 0 1px 0;
            -moz-box-shadow: rgba(0, 0, 0, 1) 0 1px 0;
            box-shadow: rgba(0, 0, 0, 1) 0 1px 0;
            text-shadow: rgba(0, 0, 0, .4) 0 1px 0;
            color: white;
            font-size: 24px;
            font-family: Georgia, serif;
            text-decoration: none;
            vertical-align: middle;
        }

        .button:hover {
            border-top-color: #28597a;
            background: #28597a;
            color: #ccc;
        }

        .button:active {
            border-top-color: #1b435e;
            background: #1b435e;
        }

        *,
        :after,
        :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }



        @media (min-width:640px) {
            .sm\:rounded-lg {
                border-radius: .5rem
            }

            .sm\:block {
                display: block
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:h-20 {
                height: 5rem
            }

            .sm\:ml-0 {
                margin-left: 0
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width:768px) {

            #image {
                margin-left: 12px;
                margin-top: 50px;
                width: 638px;
                height: 400px;
            }
        }

        @media (min-width:1024px) {

            #image {
                margin-left: 12px;
                margin-top: 50px;
                width: 638px;
                height: 400px;
            }
        }

        @media (prefers-color-scheme:dark) {
            .dark\:bg-gray-800 {
                --bg-opacity: 1;
                background-color: #2d3748;
                background-color: rgba(45, 55, 72, var(--bg-opacity))
            }

            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #1a202c;
                background-color: rgba(26, 32, 44, var(--bg-opacity))
            }

            .dark\:border-gray-700 {
                --border-opacity: 1;
                border-color: #4a5568;
                border-color: rgba(74, 85, 104, var(--border-opacity))
            }

            .dark\:text-white {
                --text-opacity: 1;
                color: #fff;
                color: rgba(255, 255, 255, var(--text-opacity))
            }

            .dark\:text-gray-400 {
                --text-opacity: 1;
                color: #cbd5e0;
                color: rgba(203, 213, 224, var(--text-opacity))
            }
        }

    </style>




</head>

<body>

    @if (session('success'))
        <div class="alert alert-success ">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger ">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ session('error') }}</strong>
        </div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $error }}</strong>
            </div>
        @endforeach
    @endif

    <div class="container">
        <div class="row ">
            <div class="col-lg-5 mt-5" id="col" style="margin-left: -10px">
                {{-- <img src="{{asset('admin/dist/images/google.jpg')}}" alt="" srcset=""> --}}
                <label for="" class="font-weight-bold mb-5" style="font-size: 28px;">CR Management System</label>
                <a href="{{ route('auth.google.login') }}" class="btn btn-block button" id="button"
                    style="font-size: 20px; text-align:left;">
                    <i class="fab fa-google-plus mr-2"></i> Employee Login
                </a>
            </div>
            <div class="col-md-5 offset-1" id="image">
                <img src="{{ asset('admin/dist/images/meeting-room_1.jpg') }}" alt="" srcset=""
                    class="img-responsive rounded img-circle" height="650px" width="640px">
            </div>
        </div>

    </div>
</body>

</html>
