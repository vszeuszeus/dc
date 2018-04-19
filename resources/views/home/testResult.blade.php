@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="jumbotron d-flex align-items-center flex-column text-center">
                    <h1 class="display-4">Результаты теста</h1>
                    <p class="lead">По теме: &laquo; Категория 1. Лекция 1
                        &raquo;</p>
                    <ul class="list-group mb-3">
                        <a href=""
                           class="list-group-item d-flex flex-column justify-content-center align-items-center box-shadow"
                           style="width: 256px;height: 256px; border-radius: 50%; color:#212121;">
                            <h2><strong>1 из 4</strong></h2>
                            <span class="lead w100 text-center"
                                  style="font-size: .8rem;">Нажмите, чтобы получить сертификат</span>
                        </a>
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection
