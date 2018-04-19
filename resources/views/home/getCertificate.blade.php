@extends('layouts.app')

@section('content')
    <style>
        /*
         * Custom translucent site header
         */

        .site-header a {
            color: #999;
            transition: ease-in-out color .15s;
        }

        .site-header a:hover {
            color: #fff;
            text-decoration: none;
        }

        /*
         * Extra utilities
         */

        .flex-equal > * {
            -ms-flex: 1;
            flex: 1;
        }

        @media (min-width: 768px) {
            .flex-md-equal > * {
                -ms-flex: 1;
                flex: 1;
            }
        }

        .overflow-hidden {
            overflow: hidden;
        }
    </style>
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-6 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">Спасибо за заявку</h1>
            <p class="lead font-weight-normal">Наши менеджеры в скором времени свяжуться с Вами и проведут полную
                консультацию.</p>
            <a class="btn btn-outline-secondary" href="{{ url('/') }}">На главную</a>
        </div>
    </div>
@endsection
