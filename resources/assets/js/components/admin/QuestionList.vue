<template>
    <div class="container">
        <template v-for="(question, index) in reverseQuestions">
            <div class="row mb-2">
                <div class="col-lg-1 text-danger align-middle text-center">
                    <span class="">{{index + 1}}</span>
                </div>
                <template v-if="editIndex.question === question.id">
                    <div class="col-lg-9">
                        <input v-model="questionTitle" v-validate="'required|max:255'"
                               name="questionTitle"
                               :class="{'form-control':true, 'border border-danger': errors.has('questionTitle')}"
                        />
                        <div v-show="errors.has('questionTitle')" class="alert alert-danger mt-1">{{
                            errors.first('questionTitle') }}
                        </div>
                    </div>
                    <div class="col-lg-2 align-middle text-right">
                        <button v-on:click="updateQuestion(question)" title="Сохранить изменения" class="btn btn-success btn-sm"><i
                                class="fa fa-check"></i></button>
                        <button v-on:click="cancelEditQuestion()" title="Отменить редактирование" class="btn btn-outline-danger btn-sm"><i
                                class="fa fa-ban"></i></button>
                    </div>
                </template>
                <template v-else>
                    <div class="col-lg-9">
                        <span>{{question.title}}</span>
                    </div>
                    <div class="col-lg-2 align-middle text-right">
                        <button v-on:click="createAnswer(question)" title="Добавить ответ" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i></button>
                        <button v-on:click="editQuestion(question)" title="Редактировать вопрос" class="btn btn-warning btn-sm"><i
                                class="fa fa-edit"></i></button>
                        <button v-on:click="deleteQuestion(index, question)" title="Удалить вопрос" class="btn btn-danger btn-sm"><i
                                class="fa fa-times"></i></button>
                    </div>
                </template>
            </div>
            <hr class="my-0 py-1">
            <div v-if="storeIndex === question.id" class="row mb-2">
                <div class="col-lg-1"></div>
                <div class="col-lg-11">
                    <div class="row">
                        <div class="col-lg-1"><i class="fa fa-plus"></i></div>
                        <div class="col-lg-9">
                            <input v-model="answerTitle" v-validate="'required|max:255'"
                                   name="answerTitle"
                                   :class="{'form-control':true, 'border border-danger': errors.has('answerTitle')}"
                            />
                            <div v-show="errors.has('answerTitle')" class="alert alert-danger mt-1">{{
                                errors.first('answerTitle') }}
                            </div>
                        </div>
                        <div class="col-lg-2 text-right align-middle">
                            <button v-on:click="storeAnswer(question)" title="Сохранить новый ответ" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i>
                            </button>
                            <button v-on:click="cancelCreateAnswer()" title="Отменить добавление ответа" class="btn btn-danger btn-sm"><i
                                    class="fa fa-ban"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2 border-bottom border-primary">
                <div class="col-lg-1"></div>
                <div class="col-lg-11">
                    <template v-for="(answer, indexA) in question.answers">
                        <div class="row mb-1">
                            <div class="col-lg-1 align-middle text-center">
                                <span class="">{{indexA + 1}}</span>
                            </div>
                            <template v-if="editIndex.answer === answer.id">
                                <div class="col-lg-7">
                                    <input v-model="answerTitle" v-validate="'required|max:255'"
                                           name="answerTitle"
                                           :class="{'form-control':true, 'border border-danger': errors.has('answerTitle')}"
                                    />
                                    <div v-show="errors.has('answerTitle')" class="alert alert-danger mt-1">@{{
                                        errors.first('answerTitle') }}
                                    </div>
                                </div>
                                <div class="col-lg-2 align-middle text-right">
                                    <span v-if="answer.trusted" class="bg-success">верный</span>
                                    <span v-else :class="'bg-danger'">неверный</span>
                                </div>
                                <div class="col-lg-2  text-right align-middle">
                                    <button v-on:click="updateAnswer(answer)" title="Сохранить изменения ответа" class="btn btn-outline-success btn-sm"><i
                                            class="fa fa-check"></i></button>
                                    <button v-on:click="cancelEditAnswer()" title="Отменить изменение ответа" class="btn btn-outline-danger btn-sm"><i
                                            class="fa fa-ban"></i></button>
                                </div>
                            </template>
                            <template v-else>
                                <div class="col-lg-7">
                                    <span>{{ answer.title }}</span>
                                </div>
                                <div class="col-lg-2 align-middle text-right">
                                    <span v-if="answer.trusted" class="bg-success">верный</span>
                                    <span style="cursor:pointer;" v-on:click="setTrueAnswer(answer, question)" v-else
                                          :class="'bg-danger'">неверный</span>
                                </div>
                                <div class="col-lg-2 text-right align-middle">
                                    <button v-on:click="editAnswer(answer)" title="Редактировать ответ" class="btn btn-outline-warning btn-sm"><i
                                            class="fa fa-edit"></i></button>
                                    <button v-on:click="deleteAnswer(index, indexA, answer, question)"
                                            title="Удалить ответ"
                                            class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i></button>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        props: ['questions'],
        data: function () {
            return {
                questionTitle: "",
                answerTitle: "",
                trustedAnswer: false,
                editIndex: {
                    question: 0,
                    answer: 0
                },
                storeIndex: 0
            }
        },
        computed: {
            reverseQuestions: function () {
                return this.questions;
            }
        },
        methods: {
            cancelEditQuestion: function () {
                this.editIndex.question = 0;
            },
            cancelEditAnswer: function () {
                this.editIndex.answer = 0;
            },
            createAnswer: function (question) {
                this.storeIndex = question.id
                this.cancelEditQuestion();
                this.cancelEditAnswer();
            },
            cancelCreateAnswer: function () {
                this.storeIndex = 0;
            },
            storeAnswer: function (question) {
                let vm = this;
                vm.$validator.validate('answerTitle', vm.answerTitle).then(result => {
                    if(!result) return;
                    let trusted = (question.answers.filter(item => {
                        return item.trusted
                    }).length === 0);
                    axios({
                        url: '/answers',
                        method: 'post',
                        data: {
                            title: vm.answerTitle,
                            trusted: trusted,
                            question_id: question.id
                        }
                    }).then(r=> {
                        question.answers.push(r.data);
                        vm.cancelCreateAnswer();
                    }).catch(e=> {
                        alert(e);
                    });
                })
            },
            editQuestion: function (question) {
                this.questionTitle = question.title;
                this.editIndex.question = question.id;
            },
            updateQuestion: function (question) {
                let vm = this;
                axios({
                    method: 'patch',
                    url: '/questions/' + question.id,
                    data: {
                        title: vm.questionTitle,
                        test_id: question.test_id
                    }
                })
                    .then(response => {
                        question.title = vm.questionTitle;
                        vm.editIndex.question = 0;
                        startAlert(vm.$parent, 'Вопрос изменен', 'success');
                    })
                    .catch(error => {
                        switch (error.response.status) {
                            case 422:
                                startAlert(vm.$parent, 'Ошибка при валидации', 'danger');
                                break;
                        }
                    });
            },
            deleteQuestion: function (index, question) {
                let vm = this;
                if (confirm('Вы действительно хотите удалить вопрос № ' + (index + 1) + '?')) {
                    axios({
                        method: 'delete',
                        url: '/questions/' + question.id
                    })
                        .then(response => {
                            vm.$parent.deleteQuestion(question);
                            startAlert(vm.$parent, 'Вопрос удален', 'success');
                        })
                        .catch(error => {
                            alert(error);
                        });
                }
            },
            editAnswer: function (answer) {
                this.answerTitle = answer.title;
                this.trustedAnswer = answer.trusted;
                this.editIndex.answer = answer.id;
            },
            updateAnswer: function (answer) {
                let vm = this;
                axios({
                    method: 'patch',
                    url: '/answers/' + answer.id,
                    data: {
                        title: vm.answerTitle,
                        trusted: answer.trusted,
                        question_id: answer.question_id
                    }
                })
                    .then(response => {
                        answer.title = vm.questionTitle;
                        vm.editIndex.answer = 0;
                        startAlert(vm.$parent, 'Ответ изменен', 'success');
                    })
                    .catch(error => {
                        switch (error.response.status) {
                            case 422:
                                startAlert(vm.$parent, 'Ошибка при валидации', 'danger');
                                break;
                        }
                    });
            },
            setTrueAnswer: function (answer, question) {
                axios({
                    url: '/answers/' + answer.id + '/setTrusted',
                    method: 'put',
                    data: {
                        title: answer.title,
                        trusted: true,
                        question_id: answer.question_id
                    }
                })
                    .then(reponse => {
                        question.answers.forEach(item => {
                            item.trusted = false;
                        });
                        answer.trusted = true;
                    })
                    .catch(e => {
                        switch (e.response.status) {
                            case 403:
                                alert('Сессия закрыта. Перезагрузите страницу!');
                                break;
                            case 404:
                                alert('Возможно ответ уже был удален');
                                break;
                            case 500:
                                alert('Ошибка на сервере. Попробуйте позже');
                        }
                    });
            },
            deleteAnswer: function (index, indexA, answer, question) {
                let vm = this;
                if (answer.trusted) {
                    startAlert(vm.$parent, 'Невозможно удалить правильный вопрос', 'warning');
                    return;
                }
                if (confirm('Вы действительно хотите удалить ответ № ' + (indexA + 1) + ' из вопроса № ' + (index + 1) + '?')) {
                    axios({
                        method: 'delete',
                        url: '/answers/' + answer.id
                    })
                        .then(response => {
                            question.answers.splice(index, 1);
                            startAlert(vm.$parent, 'Ответ удален', 'success');
                        })
                        .catch(error => {
                            alert(error);
                        });
                }
            }
        }

    }
</script>
