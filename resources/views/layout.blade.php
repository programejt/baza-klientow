<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Klienci</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ URL::asset('css/style.min.css') }}" rel="stylesheet">

        @if (isset($css))
          @foreach ($css as $style)
            <link href="{{ URL::asset('css/'.$style.'.min.css') }}" rel="stylesheet">
          @endforeach
        @endif

        <!-- Scripts -->

        @if (isset($js))
          @foreach ($js as $script)
            <script src="{{ URL::asset('js/'.$script.'.min.js') }}"></script>
          @endforeach
        @endif
    </head>
    <body>
      <main>
        @yield('content')
      </main>
    </body>
</html>
