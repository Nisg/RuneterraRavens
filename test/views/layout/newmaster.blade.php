<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title> @yield('title') </title>

        {{ HTML::script('http://code.jquery.com/jquery-2.1.1.min.js') }}
        
        @yield('head')

    </head>
    <body>
        <section>
            @yield('content')
        </section>
    </body>
</html>