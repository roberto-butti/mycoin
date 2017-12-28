<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"  class="has-navbar-fixed-top">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MyCoin') }} {{ app()->version() }}</title>
        <!--script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script-->

        <!-- Styles -->
        <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"-->
        <script defer src="https://use.fontawesome.com/releases/v5.0.2/js/all.js"></script>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
    
    
        <div id="app">
            @include('block.menu')
            @yield('content')
        </div>
        @include('block.footer')

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
