@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Категория</li>
                            <li class="breadcrumb-item active" aria-current="page">Лекция</li>
                            <li class="breadcrumb-item active" aria-current="page">Тест</li>
                        </ol>
                    </nav>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                Вопрос 1
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio1" name="customRadio"
                                               class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio1">Ответ 1</label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio2" name="customRadio"
                                               class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio2">Ответ 2</label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio3" name="customRadio"
                                               class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio2">Ответ 3</label>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <a href="#" class="btn btn-primary mt-3">Проверить результаты</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
