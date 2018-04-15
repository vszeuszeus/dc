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
        a,
        a:focus,
        a:hover {
            color: #fff;
        }

        /* Custom default button */
        .btn-secondary,
        .btn-secondary:hover,
        .btn-secondary:focus {
            color: #333;
            text-shadow: none; /* Prevent inheritance from `body` */
            background-color: #fff;
            border: .05rem solid #fff;
        }

        /*
         * Base structure
         */

        html,
        body {
            height: 100%;
            background-color: rgba(51, 51, 51, .6);
        }

        .background-image {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;

            z-index: -1;

            background-image: url(https://img5.lalafo.com/i/posters/original/87/94/03481a7fbe0e0708b136d01d8265.jpeg);
            background-size: cover;

            -webkit-filter: blur(5px);
            -moz-filter: blur(5px);
            -o-filter: blur(5px);
            -ms-filter: blur(5px);
            filter: blur(5px);
        }

        body {
            display: -ms-flexbox;
            display: -webkit-box;
            display: flex;
            -ms-flex-pack: center;
            -webkit-box-pack: center;
            justify-content: center;
            color: #fff;
            text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
            box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
        }

        .cover-container {
            max-width: 42em;
        }

        /*
         * Header
         */
        .masthead {
            margin-bottom: 2rem;
        }

        .masthead-brand {
            margin-bottom: 0;
        }

        .nav-masthead .nav-link {
            padding: .25rem 0;
            font-weight: 700;
            color: rgba(255, 255, 255, .5);
            background-color: transparent;
            border-bottom: .25rem solid transparent;
        }

        .nav-masthead .nav-link:hover,
        .nav-masthead .nav-link:focus {
            border-bottom-color: rgba(255, 255, 255, .25);
        }

        .nav-masthead .nav-link + .nav-link {
            margin-left: 1rem;
        }

        .nav-masthead .active {
            color: #fff;
            border-bottom-color: #fff;
        }

        @media (min-width: 48em) {
            .masthead-brand {
                float: left;
            }

            .nav-masthead {
                float: right;
            }
        }

        /*
         * Cover
         */
        .cover {
            padding: 0 1.5rem;
        }

        .cover .btn-lg {
            padding: .75rem 1.25rem;
            font-weight: 700;
        }

        /*
         * Footer
         */
        .mastfoot {
            color: rgba(255, 255, 255, .5);
        }
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