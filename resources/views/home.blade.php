@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Название категории</div>

                    <div class="card-body">

                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Лекции
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="#">Лекция 1</a>
                                    <a class="dropdown-item" href="#">Лекция 2</a>
                                    <a class="dropdown-item" href="#">Лекция 3</a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary">Итоговый тест</button>
                            <button type="button" class="btn btn-secondary">Получить сертификат</button>
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-top: 1em">
                    <div class="card-header">Название категории</div>

                    <div class="card-body">

                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Лекции
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="#">Лекция 1</a>
                                    <a class="dropdown-item" href="#">Лекция 2</a>
                                    <a class="dropdown-item" href="#">Лекция 3</a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary">Итоговый тест</button>
                            <button type="button" class="btn btn-secondary">Получить сертификат</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
