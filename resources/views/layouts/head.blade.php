<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>@yield('title'){{env('APP_NAME')}}</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Gochi+Hand|Reenie+Beanie" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/global.css')}}" rel="stylesheet" type="text/css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        @yield('stylesheets')

        <!-- Scripts -->
        <script>
            APP_URL = '{{env('APP_URL')}}';
        </script>
        <script src="{{asset('js/axios.js')}}"></script>
        <script src="{{asset('js/popper.js')}}"></script>
        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/app.js')}}" defer></script>
        <script src="{{asset('js/nicescroll.js')}}" defer></script>
        @yield('scripts')
    </head>
    <body>
