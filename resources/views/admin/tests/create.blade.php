@extends('layouts.admin')

@section('content')
    <div id="testEditor">
        <div v-if="finalCaption" style="z-index: 999999; position: fixed; top:5%; width:400px; right:5%;">
            <div class="col-lg-12">
                <div :class="'alert alert-' + finalCaptionClass + ' alert-dismissible fade show'" role="alert">
                    @{{finalCaption}}
                    <button type="button" class="close" v-on:click="dismissAlert()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div v-if="step === 1" class="card">
                    <div class="card-header">Редактор теста</div>

                    <div class="card-body">
                        <div>
                            <div class="form-input">
                                <label for="title">Наименование</label>
                                <input v-model="titleField" name="title" type="text" class="form-control"/>
                            </div>
                            <div class="form-input mt-1">
                                <label for="">Тип теста</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" v-model="typeField" type="radio" id="typeItog"
                                           value="1">
                                    <label class="form-check-label" for="typeItog">Итоговый</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" v-model="typeField" type="radio" id="typeLecture"
                                           value="2">
                                    <label class="form-check-label" for="typeLecture">Лекционный</label>
                                </div>
                            </div>
                            <div class="form-input">
                                <label for="category">Категория</label>
                                <select :disabled="(categories.length === 0)" class="form-control" v-model="categoryField">
                                    <option value="">Выберите категорию</option>
                                    <option v-for="category in categories" :value="category.id">@{{ category.title }}
                                    </option>
                                </select>
                            </div>
                            <div v-if="typeField == 2" class="form-input mt-2">
                                <label for="category">Лекция</label>
                                <select :disabled="(lectures.length === 0)" class="form-control" v-model="lectureField">
                                    <option value="">Выберите лекцию</option>
                                    <option v-for="lecture in lectures" :value="lecture.id">@{{ lecture.title }}
                                    </option>
                                </select>
                            </div>
                            <hr>
                            <button class="btn btn-primary">Сохранить и перейти к вопросам</button>
                        </div>
                    </div>
                </div>
                <div v-else-if="step === 2" class="card">
                    <div class="card-header">Добавление вопросов</div>

                    <div class="card-body">
                        <button class="btn btn-primary mb-3" v-on:click="addQuestion()">Добавить вопрос</button>
                        <div class="card" v-if="createQuestion">
                            <div class="card-body">
                                <div class="form-input">
                                    <label for="questionTitle">Вопрос</label>
                                    <input class="form-control" type="text" name="questionTitle" id="questionTitle"
                                           v-model="questionTitle"/>
                                </div>
                                <div class="form-input">
                                    <button class="btn btn-default mt-2" v-on:click="addAnswer()">
                                        Добавить овтет
                                    </button>
                                </div>
                                <div class="answers">
                                    <table v-if="toAddAnswers.length > 0"
                                           class="table table-bordered table-hover mt-2">
                                        <tr>
                                            <th style="width:30px;">#</th>
                                            <th colspan="3">Ответ</th>
                                            <th style="width:70px;">Статус</th>
                                            <th style="width:100px;">Функции</th>
                                        </tr>
                                        <tr v-for="(answer, index) in toAddAnswers">
                                            <td>@{{(index + 1)}}</td>
                                            <td colspan="3">@{{answer.title}}</td>
                                            <td>
                                                    <span v-if="answer.trusted"
                                                          class="py-1 px-1 bg-success">Верный</span>
                                                <span v-else class="py-1 px-1 bg-danger">Неверный</span>
                                            </td>
                                            <td>
                                                <button v-on:click="editToAddAnswer(answer, index)"
                                                        class="btn btn-warning btn-sm" title="Редактировать"><i
                                                            class="fa fa-edit"></i></button>
                                                <button v-on:click="deleteToAddAnswer(index)"
                                                        class="btn btn-danger btn-sm" title="Удалить"><i
                                                            class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <hr>
                                <div class="form-input">
                                    <button class="btn btn-outline-primary">
                                        Сохранить
                                    </button>
                                    <button v-on:click="addQuestion()" class="btn btn-outline-primary">
                                        Отмена
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal answer -->
        <div class="modal fade" id="answerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="(modalType === 'createToAdd')" class="modal-title" id="exampleModalLabel">Добавление ответа</h5>
                        <h5 v-else-if="(modalType === 'editToAdd')" class="modal-title" id="exampleModalLabel">Редактирование ответа</h5>
                        <button type="button" class="close" v-on:click="cancelAddAnswer()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-input">
                            <label for="answerInput">Введите ответ</label>
                            <input v-validate="'required|min:1'" type="text" name="answerInput" id="answerInput"
                                   :class="{'form-control': true,'text-danger': errors.has('answerInput')}"
                                   placeholder="Введите ответ"
                                   v-model="answerInput"/>
                            <span v-show="errors.has('answerInput')" class="help text-danger">@{{ errors.first('answerInput') }}</span>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" v-model="trueAnswer" type="checkbox" :value="true"
                                   id="trueAnswer">
                            <label class="form-check-label" for="trueAnswer">
                                Отметить как правильный
                            </label>
                        </div>
                        <div v-if="editAnswerError">
                            <div class="alert alert-warning alert-dismissible fade show mt-2 mb-0" role="alert">
                                В этом вопросе уже присутствует правильный ответ
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" v-on:click="cancelAddAnswer()">Отмена</button>
                        <button v-if="(modalType === 'createToAdd')" type="button" class="btn btn-primary"
                                v-on:click="storeToAddAnswer()">Сохранить</button>
                        <button v-else-if="(modalType === 'editToAdd')" type="button" class="btn btn-primary"
                                v-on:click="updateToAddAnswer()">Обновить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php echo "<script>var phpToVueData = ".json_encode($data).";</script>" @endphp
@endsection
