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
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">

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
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                All rights reserved
            </p>
        </div>
    </footer>
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>