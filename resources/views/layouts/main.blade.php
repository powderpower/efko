<!DOCTYPE html>
<html lang="ru">
    <head>
        @include('layouts.head')
        <link href="css/app.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <nav class="navbar navbar-dark bg-info">
            <div class='container'>
                <a class="navbar-brand" href="/">
                    <div class='d-inline-block align-top img top-line @if(Auth::check()) top-page @else top-lock @endif'></div>
                    <span class='ml-2'>@yield('pagename')</span>
                </a>
                @yield('extra-btn')
            </div>
        </nav>         
        <div class="container mt-4 mb-4">            
            @yield('content')
        </div>
        
        <script type="text/javascript" src="js/app.js"></script>
    </body>
</html>