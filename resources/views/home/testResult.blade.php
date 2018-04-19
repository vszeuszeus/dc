@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="jumbotron">
                    <h1 class="display-4">Результаты теста</h1>
                    <p class="lead">По теме: &laquo; Категория 1. Лекция 1 &raquo;</p>
                    <hr class="my-4">
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <div class="text-danger">
                                <h6 class="my-0">Вопрос</h6>
                                <small>Правильный ответ</small>
                            </div>
                            <span class="text-danger"> // ответ, который дал пользователь//</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <div class="text-danger">
                                <h6 class="my-0">Вопрос</h6>
                                <small>Правильный ответ</small>
                            </div>
                            <span class="text-danger"> // ответ, который дал пользователь//</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <div class="text-danger">
                                <h6 class="my-0">Вопрос</h6>
                                <small>Правильный ответ</small>
                            </div>
                            <span class="text-danger"> // ответ, который дал пользователь//</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <div class="text-success">
                                <h6 class="my-0">Вопрос</h6>
                                <small>Правильный ответ</small>
                            </div>
                            <span class="text-success"> // ответ, который дал пользователь//</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Результат</span>
                            <strong>1 из 4</strong>
                        </li>
                    </ul>
                    <p class="lead text-center">
                        <a class="btn btn-primary btn-lg" href="#" role="button">Получить сертификат</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
@endsection
