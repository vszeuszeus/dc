@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include('common.errors')
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{route('tests.check')}}" method="POST">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page"></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$begin->test->testable->title}}</li>
                                {{--@if($begin->test->testable_type === 'App\\Lecture')
                                    <li class="breadcrumb-item active" aria-current="page">$begin->test->testable->title</li>
                                @endif--}}
                            </ol>
                        </nav>
                        <div class="card-body">
                                {{csrf_field()}}
                                <input type="hidden" name="test_id" value="{{$begin->test->id}}"/>
                                <input type="hidden" name="test_key" value="{{$begin->test_key}}"/>
                            @foreach($begin->test->questions as $question)
                                <div class="card mb-2">
                                    <div class="card-header">
                                        {{$question->title}}
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        @foreach($question->answers as $answer)
                                            <li class="list-group-item">
                                                <div class="custom-control custom-radio">
                                                    <input value="{{$answer->id}}" type="radio" id="answer{{$answer->id}}" name="answers[{{$question->id}}]"
                                                           class="custom-control-input">
                                                    <label class="custom-control-label" for="answer{{$answer->id}}">{{ $answer->title }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">Проверить результаты</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
