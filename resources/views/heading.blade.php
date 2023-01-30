<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">    
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Crypto currencies</title>
    </head>
    <body>
        <div class="heading parent">
            <div>
                <a href="/"><h1 class="home_button">CRYPTO home</h1></a>
            </div>
            <div>
                <form type="get" action="{{url('/search')}}" class="search_bar">
                    <input type="text" name="query" placeholder="Search for cryptocurrency"></input>
                    <button class="button1" type="submit">Search</button>
                </form>
            </div>
        </div>
    </body>
</html>

@yield('content')