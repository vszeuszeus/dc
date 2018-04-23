@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="jumbotron d-flex align-items-center flex-column text-center">
                    <h1 class="display-4">Результаты теста</h1>
                    <p class="lead">По теме: &laquo;{{$begin->test->testable->title}}&raquo;</p>
                    <ul class="list-group mb-3">
                        @if($begin->checkResult())
                            @if($begin->test->testable_type == 'App\Lecture')
                                <a href="{{route('home')}}"
                                   class="list-group-item d-flex flex-column justify-content-center align-items-center box-shadow"
                                   style="width: 256px;height: 256px; border-radius: 50%; color:#212121;">
                                    <h2><strong>{{$begin->result_count}} из {{$begin->questions_count}}</strong></h2>
                                    <span class="lead w100 text-center"
                                          style="font-size: .8rem;">Тест пройден</span>
                                    <span class="lead w100 text-center"
                                          style="font-size: .8rem;">Вернуться к лекциям</span>
                                </a>
                            @else
                                <a href="{{route('home.getCertificate', $begin->test->testable->id)}}"
                                   class="list-group-item d-flex flex-column justify-content-center align-items-center box-shadow"
                                   style="width: 256px;height: 256px; border-radius: 50%; color:#212121;">
                                    <h2><strong>{{$begin->result_count}} из {{$begin->questions_count}}</strong></h2>
                                    <span class="lead w100 text-center"
                                          style="font-size: .8rem;">Тест пройден</span>
                                    <span class="lead w100 text-center"
                                          style="font-size: .8rem;">Нажмите, чтобы получить сертификат</span>

                                </a>
                            @endif
                        @else
                            <a href="{{route('home')}}"
                               class="list-group-item d-flex flex-column justify-content-center align-items-center box-shadow"
                               style="width: 256px;height: 256px; border-radius: 50%; color:#212121;">
                                <h2><strong>{{$begin->result_count}} из {{$begin->questions_count}}</strong></h2>
                                <span class="lead w100 text-center"
                                      style="font-size: .8rem;">Тест не пройден</span>
                                <span class="lead w100 text-center"
                                      style="font-size: .8rem;">Вернуться к лекциям</span>
                            </a>
                        @endif

                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection
