<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Центр образования и воспитания</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <style>
        /*
 * Globals
 */

        /* Links */

    </style>
</head>

<body class="text-center">

<div class="background-image"></div>

<div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
    <header class="masthead mb-auto">
        <div class="inner">
            <h3 class="masthead-brand">ЦОиВ</h3>
            @if (Route::has('login'))
                <nav class="nav nav-masthead justify-content-center">
                    @auth
                        <a class="nav-link active" href="{{ url('/home') }}">Личный кабинет</a>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Вход</a>
                        <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <main role="main" class="inner cover">
        <h1 class="cover-heading">Центр образования и воспитания</h1>
        <p class="lead">Конкурсы | Олимпиады | Викторины | Конференции</p>
    </main>

    <footer class="mastfoot mt-auto">
        <div class="inner">
            <p>Lorem ipsum dolor sit amet, consectetur.</p>
        </div>
    </footer>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>