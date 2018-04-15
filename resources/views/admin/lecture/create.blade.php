@extends('layouts.admin')

@section('content')
<div id="listerAdd">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Добавление лекции</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @include('common.errors')
                        <form method="POST" action="{{route('lectures.store')}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Наименование</label>
                                <input placeholder="Наименование" type="text" value="{{old('title', "")}}" name="title" id="title" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="category">Категория</label>
                                <select name="lecture_category_id" id="category" class="form-control">
                                    <option value="">Выберите категорию</option>
                                    @php $categoryL = old('lecture_category_id', 0); @endphp
                                    @foreach($categories as $category)
                                        @if($categoryL == $category->id)
                                            <option selected="selected" value="{{$category->id}}">{{$category->title}}</option>
                                        @else
                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bodyD">Тело статьи</label>
                                <textarea placeholder="Тело статьи" class="form-control" id="bodyD" name="body">{{old('body', "")}}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Сохранить</button>
                                <a href="{{route('lectures.index')}}" class="btn btn-default"><i class="fa fa-times"></i> Отмена</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
