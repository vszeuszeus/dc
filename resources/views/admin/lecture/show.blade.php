@extends('layouts.admin')

@section('content')
    <div id="listerAdd">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">Лекция № {{$lecture->id}}</div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="mb-4">
                                <a class="btn btn-primary" href="{{route('lectures.edit', $lecture->id)}}">
                                    <i class="fa fa-edit"></i> Редатировать</a>
                                <button class="btn btn-danger" type="button" onclick="
                                event.preventDefault();
                                if(confirm('Вы хотите удалить эту лекцию?')){
                                    document.getElementById('delete_lecture').submit();
                                }"><i class="fa fa-trash"></i> Удалить</button>
                                <form id="delete_lecture" method="POST" action="{{route('lectures.destroyWeb', $lecture->id)}}">
                                    {{csrf_field()}}
                                    {{method_field('DELETE')}}
                                </form>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <span>Наименование:</span><h3>{{$lecture->title}}</h3>
                                </div>
                            </div>
                                <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <span>Категория:</span>
                                    <p class="pb-0 mb-0">{{$lecture->category->title}}</p>
                                </div>
                            </div>
                                <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div>{!! $lecture->body !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
