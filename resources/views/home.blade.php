@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($categories as $category)
                    @if($loop->first)
                        <div class="card">
                            @else
                                <div class="card mt-3">
                                    @endif
                                    <div class="card-header">{{$category->title}}</div>

                                    <div class="card-body">

                                        <div class="btn-group d-none d-sm-inline-flex" role="group">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button"
                                                        class="btn btn-secondary @if(!$category->lectures->count()) disabled @endif dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    Лекции
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    @foreach($category->lectures as $lecture)
                                                        <a class="dropdown-item"
                                                           href="{{route('home.readLecture', $lecture->id)}}">{{$lecture->title}}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @if(!$category->lectures->count())
                                                <button disabled
                                                        href="{{route('home.beginTest', ['type' => 'LectureCategory', 'id' => $category->id])}}"
                                                        type="button"
                                                        class="btn btn-secondary">Итоговый тест
                                                </button>
                                            @else
                                                <a href="{{route('home.beginTest', ['type' => 'LectureCategory', 'id' => $category->id])}}"
                                                   type="button"
                                                   class="btn btn-secondary">Итоговый тест</a>
                                            @endif

                                            @if($category->checkPassedTest())
                                                <a disabled href="{{route('home.getCertificate', $category->id)}}"
                                                   class="btn btn-secondary">Получить сертификат</a>
                                            @else
                                                <button disabled href="{{route('home.getCertificate', $category->id)}}"
                                                        class="btn btn-secondary">Получить сертификат
                                                </button>
                                            @endif
                                        </div>

                                        <div class="btn-group-vertical d-inline-flex d-sm-none w-100" role="group">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button"
                                                        class="btn btn-secondary @if(!$category->lectures->count()) disabled @endif dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    Лекции
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    @foreach($category->lectures as $lecture)
                                                        <a class="dropdown-item"
                                                           href="{{route('home.readLecture', $lecture->id)}}">{{$lecture->title}}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @if(!$category->lectures->count())
                                                <button disabled
                                                        href="{{route('home.beginTest', ['type' => 'LectureCategory', 'id' => $category->id])}}"
                                                        type="button"
                                                        class="btn btn-secondary">Итоговый тест
                                                </button>
                                            @else
                                                <a href="{{route('home.beginTest', ['type' => 'LectureCategory', 'id' => $category->id])}}"
                                                   type="button"
                                                   class="btn btn-secondary">Итоговый тест</a>
                                            @endif

                                            @if($category->checkPassedTest())
                                                <a disabled href="{{route('home.getCertificate', $category->id)}}"
                                                   class="btn btn-secondary">Получить сертификат</a>
                                            @else
                                                <button disabled href="{{route('home.getCertificate', $category->id)}}"
                                                        class="btn btn-secondary">Получить сертификат
                                                </button>
                                            @endif
                                        </div>

                                    </div>
                                    
                                </div>
                                @endforeach
                        </div>
            </div>
        </div>
    </div>
@endsection
