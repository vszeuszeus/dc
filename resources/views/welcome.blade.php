<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Дискретная математика для всех</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">

</head>

<body class="text-center">

<div class="background-image" style="background-image: url({{ asset('images/cover.jpeg') }});"></div>

<div class="d-flex h-100 p-3 mx-auto flex-column">
    <header class="masthead mb-auto">
        <div class="inner">
            <h3 class="masthead-brand">
                <img src="{{asset('images/logo.png')}}" alt="logo" width="30" height="30">
            </h3>
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
        <h1 class="cover-heading">Дискретная математика для всех</h1>
        <p class="lead">Конкурсы | Олимпиады | Викторины | Конференции</p>
    </main>

    <footer class="mastfoot mt-auto">
        <div class="inner">
            <p>
                Джандигулов Абдыгали Реджепович 
                <a href="mailto:abeked@mail.ru">abeked@mail.ru</a>
                <a href="tel:+77014862139">+7 (701) 486-21-39</a>
            </p>
            <p>
                Тлепбай Камшат Баянкызы
                <a href="mailto:shonkiiin@mail.ru">shonkiiin@mail.ru</a>
                <a href="tel:+77078443548">+7 (707) 844-35-48</a>
            </p>
        </div>
    </footer>
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>