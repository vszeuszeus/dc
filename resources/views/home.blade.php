@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($categories as $category)
                @if($loop->first)
                    <div class="card">
                @else
                    <div class="card" style="margin-top: 1em;">
                @endif
                        <div class="card-header">{{$category->title}}</div>

                        <div class="card-body">

                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Лекции
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        @foreach($category->lectures as $lecture)
                                            <a class="dropdown-item" href="{{route('home.readLecture', $lecture->id)}}">{{$lecture->title}}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <a href="{{route('home.beginTest', $category->id)}}" type="button" class="btn btn-secondary">Итоговый тест</a>
                                <a href="{{route('home.getCertificate', $category->id)}}" class="btn btn-secondary">Получить сертификат</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
