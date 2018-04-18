<template>
    <div class="container">
        <template v-for="(question, index) in reverseQuestions">
            <div class="row">
                <div class="col-lg-1">
                    <span>{{index + 1}}</span>
                </div>
                <template v-if="editIndex.question === question.id">
                    <div class="col-lg-8">
                        <input  v-model="questionTitle" v-validate="'required|max:255'"
                                name="questionTitle"
                                :class="{'form-control':true, 'border border-danger': errors.has('questionTitle')}"
                        />
                        <div v-show="errors.has('questionTitle')" class="alert alert-danger mt-1">@{{ errors.first('questionTitle') }}</div>
                    </div>
                    <div class="col-lg-3">
                        <button v-on:click="updateQuestion(question)" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                        <button v-on:click="cancelEditQuestion()" class="btn btn-danger"><i class="fa fa-times"></i></button>
                    </div>
                </template>
                <template v-else>
                    <div class="col-lg-8">
                        <span>{{question.title}}</span>
                    </div>
                    <div class="col-lg-3">
                        <button v-on:click="editQuestion(question)" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                        <button v-on:click="deleteQuestion(index, question)" class="btn btn-danger"><i class="fa fa-times"></i></button>
                    </div>
                </template>
            </div>
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-9">
                    <template v-for="(answer, indexA) in question.answers">
                        <div class="row">
                            <div class="col-lg-1">
                                <span class="text-danger">{{indexA + 1}}</span>
                            </div>
                            <template v-if="editIndex.answer === answer.id">
                                <div class="col-lg-7">
                                    <input  v-model="answerTitle" v-validate="'required|max:255'"
                                            name="answerTitle"
                                            :class="{'form-control':true, 'border border-danger': errors.has('answerTitle')}"
                                    />
                                    <div v-show="errors.has('answerTitle')" class="alert alert-danger mt-1">@{{ errors.first('answerTitle') }}</div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input"
                                               name="trustedAnswer"
                                               v-model="trustedAnswer" type="checkbox"
                                               id="trustedAnswer">
                                        <label class="form-check-label" for="trustedAnswer">
                                            Прав/Отв
                                        </label>
                                    </div>
                                    <div v-show="errors.has('trustedAnswer')" class="alert alert-danger mt-1">@{{ errors.first('trustedAnswer') }}</div>

                                </div>
                                <div class="col-lg-2">
                                    <button v-on:click="updateAnswer(answer)" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></button>
                                    <button v-on:click="cancelEditAnswer()" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                                </div>
                            </template>
                            <template v-else >
                                <div class="col-lg-7">
                                    <span></span>
                                </div>
                                <div class="col-lg-2">
                                    <span v-if="answer.trusted" class="bg-success">верный</span>
                                    <span v-else :class="'bg-danger'">неверный</span>
                                </div>
                                <div class="col-lg-2">
                                    <button v-on:click="editAnswer(answer)" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></button>
                                    <button v-on:click="deleteAnswer(index, answer, question)" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
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
        data: function(){
            return {
                questionTitle: "",
                answerTitle: "",
                trustedAnswer: false,
                editIndex: {
                    question: 0,
                    answer: 0
                }
            }
        },
        computed: {
            reverseQuestions: function(){
                return this.questions.reverse();
            }
        },
        methods: {
            cancelEditQuestion: () => {
                this.editIndex.question = 0;
            },
            cancelEditAnswer: () => {
                this.editIndex.answer = 0;
            },
            editQuestion: (question) => {
                this.questionTitle = question.title;
                this.editIndex.question = question.id;
            },
            updateQuestion: (question) => {
                let vm = this;
                axios({
                    method: 'patch',
                    url: '/questions/' + question.id,
                    data: {
                        title: vm.questionTitle,
                        test_id: question.test_id
                    }
                })
                    .then( response => {
                        question.title = vm.questionTitle;
                        vm.editIndex.question = 0;
                        startAlert(vm.$parent, 'Вопрос изменен', 'success');
                    })
                    .catch( error => {
                        switch(error.response.status){
                            case 422:
                                startAlert(vm.$parent, 'Ошибка при валидации', 'danger');
                                break;
                        }
                    });
            },
            deleteQuestion: (index, question) => {
                let vm = this;
                if(confirm('Вы действительно хотите удалить вопрос № ' + index + '?')){
                    axios({
                        method: 'delete',
                        url: '/questions/' + question.id
                    })
                        .then( response => {
                            vm.$parent.deleteQuestion(question);
                            startAlert(vm.$parent, 'Вопрос удален', 'success');
                        })
                        .catch( error => {
                            alert(error);
                        });
                }
            },
            editAnswer: (answer) => {
                this.answerTitle = answer.title;
                this.trustedAnswer = answer.trusted;
                this.editIndex.answer = answer.id;
            },
            updateAnswer: (answer) => {
                let vm = this;
                axios({
                    method: 'patch',
                    url: '/answers/' + answer.id,
                    data: {
                        title: vm.questionTitle,
                        trusted: vm.trustedAnswer,
                        question_id: answer.test_id
                    }
                })
                    .then( response => {
                        answer.title = vm.questionTitle;
                        answer.trusted = vm.trustedAnswer;
                        vm.editIndex.answer = 0;
                        startAlert(vm.$parent, 'Ответ изменен', 'success');
                    })
                    .catch( error => {
                        switch(error.response.status){
                            case 422:
                                startAlert(vm.$parent, 'Ошибка при валидации', 'danger');
                                break;
                        }
                    });
            },
            deleteAnswer: (index, answer, question) => {
                let vm = this;
                if(answer.trusted){
                    startAlert(vm.$parent, 'Невозможно удалить правильный вопрос', 'warning');
                    return;
                }
                if(confirm('Вы действительно хотите удалить ответ № ' + index + '?')){
                    axios({
                        method: 'delete',
                        url: '/answers/' + answer.id
                    })
                        .then( response => {
                            question.answers.splice(index, 1);
                            startAlert(vm.$parent, 'Ответ удален', 'success');
                        })
                        .catch( error => {
                            alert(error);
                        });
                }
            }
        }

    }
</script>
