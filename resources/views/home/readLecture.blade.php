@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" id="{{$lecture->id}}">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="margin-bottom: 0;">
                            <li class="breadcrumb-item active"
                                aria-current="page">{{$lecture->category->title}}</li>
                            <li class="breadcrumb-item active" aria-current="page">{{$lecture->title}}</li>
                        </ol>
                    </nav>
                    <div class="card-body">
                        {!! $lecture->body !!}
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-primary">Пройти тест по лекции</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
