@extends('layouts.admin')

@section('content')
<div id="testEditor">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Создание теста</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div>
                        <div class="form-input">
                            <label for="title">Наименование</label>
                            <input v-model="titleField" name="title" type="text" class="form-control"/>
                        </div>
                        <div class="form-input mt-1">
                            <label for="">Тип теста</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" v-model="typeField" type="radio" id="typeItog" value="1">
                                <label class="form-check-label" for="typeItog">Итоговый</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" v-model="typeField" type="radio" id="typeLecture" value="2">
                                <label class="form-check-label" for="typeLecture">Лекционный</label>
                            </div>
                        </div>
                        <div class="form-input">
                            <label for="category">Категория</label>
                            <select  class="form-control" v-model="categoryField">
                                <option value="">Выберите категорию</option>
                                <option v-for="category in categories"  :value="category.id">@{{ category.title }}</option>
                            </select>
                        </div>
                        <div v-if="typeField == 2" class="form-input mt-2">
                            <label for="category">Лекция</label>
                            <select  class="form-control" v-model="lectureField">
                                <option value="">Выберите лекцию</option>
                                <option v-for="lecture in lectures" :value="lecture.id">@{{ lecture.title }}</option>
                            </select>
                        </div>
                        <hr>
                        <button class="btn btn-primary mb-3" v-on:click="createQuestion = true">Добавить вопрос</button>
                        <div class="card" v-if="createQuestion">
                            <div class="card-body">
                                <div class="form-input">
                                    <lable for="questionTitle">Вопрос</lable>
                                    <input class="form-control" type="text" name="questionTitle" id="questionTitle" v-model="questionTitle"/>
                                </div>
                                <div class="form-input">
                                    <button class="btn btn-primary mt-2">
                                        Добавить овтет
                                    </button>
                                </div>
                                <div class="form-input"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php echo "<script>var phpToVueData = ".json_encode($data).";</script>" @endphp
@endsection
