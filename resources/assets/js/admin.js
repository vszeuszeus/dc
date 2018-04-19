/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

require('tinymce');
require('tinymce/themes/modern/theme.min.js');
require('air-datepicker');

window.Vee = require('vee-validate');
window.VeeDictRU = require('vee-validate/dist/locale/ru');

Vue.use(Vee, {
    locale: 'ru',
    dictionary: {
        ru: {
            messages: VeeDictRU
        }
    }
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('lister-component', require('./components/admin/ListerComponent.vue'));
Vue.component('lecture-list', require('./components/admin/LectureList.vue'));
Vue.component('question-list', require('./components/admin/QuestionList.vue'));

if ($('#app').length > 0) {
    const app = new Vue({
        el: '#app'
    });
}

if ($("#lister").length > 0) {
    const lister = new Vue({
        el: '#lister',
        data: {
            listData: phpToVueData.listData,
            model: phpToVueData.model,
            name: phpToVueData.name,
            finalCaption: "",
            finalCaptionClass: ""
        },
        mounted() {
            console.log('lister mounted');
        },
        methods: {
            dismissAlert: function () {
                this.finalCaption = "";
            }
        }
    });
}

if ($("#lectures").length > 0) {
    const lectures = new Vue({
        el: '#lectures',
        data: {
            paginateData: {
                current_page: 1,
                data: [],
                first_page_url: "",
                from: null,
                last_page: 1,
                last_page_url: "",
                next_page_url: null,
                path: "",
                per_page: 15,
                prev_page_url: null,
                to: null,
                total: 0
            },
            titleField: "",
            createdAtField: "",
            categoryField: "",
            searchCaption: "Укажите параметры поиска для зароса!",
            searchCaptionClases: "alert alert-info",
            finalCaption: "",
            categories: backToFront.categories,
        },
        computed: {
            lectures: function () {
                return this.paginateData.data;
            }
        },
        watch: {
            titleField: function () {
                this.startSearch();
            },
            createdAtField: function () {
                this.startSearch();
            },
            categoryField: function () {
                this.startSearch();
            }
        },
        methods: {

            startSearch: function () {
                this.searchCaptionClases = "alert alert-info";
                this.searchCaption = 'Ожидаю окончания ввода';
                this.getSearchResult();
            },

            deleteModel: function (model) {
                this.paginateData.data = this.paginateData.data.filter(item => {
                    return (item.id !== model.id)
                });
                startAlert(this, 'Лекция удалена', 'success');
            },

            getSearchResult: _.debounce(
                function () {
                    if (!this.titleField &&
                        !this.createdAtField &&
                        !this.categoryField
                    ) {
                        this.paginateData.data = [];
                        this.searchCaptionClases = 'alert alert-info';
                        this.searchCaption = "Укажите параметры поиска, чтобы начать просмотр!";
                        return
                    }
                    this.searchCaption = "Ожидайте ответ...";

                    this.uploadData();

                }, 700
            ),

            uploadData: function (url = "") {
                let vm = this;
                let baseUrl = '/lectures/searcher?'
                    + 'title_field=' + vm.titleField
                    + '&created_at_field=' + vm.createdAtField
                    + '&category_field=' + vm.categoryField
                    + url;

                axios.get(baseUrl)
                    .then(function (response) {
                        vm.paginateData = response.data;
                        if (response.data.data.length > 0) {
                            vm.reFind = true;
                            vm.searchCaptionClases = 'alert alert-success';
                            if (response.data.last_page === 1) {
                                vm.searchCaption = "Ответ получен. Всего результатов: " + response.data.data.length + ". ";
                            } else {
                                vm.searchCaption = "Ответ получен. Показано c " + response.data.from + " по " + (response.data.from + response.data.data.length - 1) + " из " + response.data.total;
                            }
                        } else {
                            vm.searchCaptionClases = 'alert alert-warning';
                            vm.searchCaption = 'Попробуйте другие варианты поиска.';
                        }
                    })
                    .catch(function (error) {
                        alert('Ошибка! Не могу связаться с API. Попробуйте заного.' + error);
                    });
            },

            getData: function (param, page) {
                this.searchCaption = "Ожидайте ответ...";
                let url = "";
                switch (param) {
                    case 'prev':
                        url += '&page=' + (this.paginateData.current_page - 1);
                        break;
                    case 'next':
                        url += '&page=' + (this.paginateData.current_page + 1);
                        break;
                    default :
                        url += '&page=' + page;
                        break;
                }
                this.uploadData(url);
            },
            dismissAlert: function () {
                this.finalCaption = "";
            }
        },
        mounted() {
            let vm = this;
            $('#createdAtField').datepicker({
                position: 'bottom left',
                autoClose: true,
                dateFormat: 'yyyy-mm-dd',
                range: true,
                toggleSelected: false,
                onSelect: function (fn, date) {
                    vm.createdAtField = fn;
                }
            });
        },
        updated() {
        }
    });
}

if ($("#lectures").length > 0) {
    const lectures = new Vue({
        el: '#lectures',
        data: {
            paginateData: {
                current_page: 1,
                data: [],
                first_page_url: "",
                from: null,
                last_page: 1,
                last_page_url: "",
                next_page_url: null,
                path: "",
                per_page: 15,
                prev_page_url: null,
                to: null,
                total: 0
            },
            titleField: "",
            createdAtField: "",
            categoryField: "",
            searchCaption: "Укажите параметры поиска для зароса!",
            searchCaptionClases: "alert alert-info",
            finalCaption: ""
        },
        computed: {
            tests: function () {
                return this.paginateData.data;
            }
        },
        watch: {
            titleField: function () {
                this.startSearch();
            },
            createdAtField: function () {
                this.startSearch();
            },
            categoryField: function () {
                this.startSearch();
            }
        },
        methods: {

            startSearch: function () {
                this.searchCaptionClases = "alert alert-info";
                this.searchCaption = 'Ожидаю окончания ввода';
                this.getSearchResult();
            },

            deleteModel: function (model) {
                this.paginateData.data = this.paginateData.data.filter(item => {
                    return (item.id !== model.id)
                });
                startAlert(this, 'Тест удален', 'success');
            },

            getSearchResult: _.debounce(
                function () {
                    if (!this.titleField &&
                        !this.createdAtField &&
                        !this.categoryField
                    ) {
                        this.paginateData.data = [];
                        this.searchCaptionClases = 'alert alert-info';
                        this.searchCaption = "Укажите параметры поиска, чтобы начать просмотр!";
                        return
                    }
                    this.searchCaption = "Ожидайте ответ...";

                    this.uploadData();

                }, 700
            ),

            uploadData: function (url = "") {
                let vm = this;
                let baseUrl = '/tests/searcher?'
                    + 'title_field=' + vm.titleField
                    + '&created_at_field=' + vm.createdAtField
                    + '&category_field=' + vm.categoryField
                    + url;

                axios.get(baseUrl)
                    .then(function (response) {
                        vm.paginateData = response.data;
                        if (response.data.data.length > 0) {
                            vm.reFind = true;
                            vm.searchCaptionClases = 'alert alert-success';
                            if (response.data.last_page === 1) {
                                vm.searchCaption = "Ответ получен. Всего результатов: " + response.data.data.length + ". ";
                            } else {
                                vm.searchCaption = "Ответ получен. Показано c " + response.data.from + " по " + (response.data.from + response.data.data.length - 1) + " из " + response.data.total;
                            }
                        } else {
                            vm.searchCaptionClases = 'alert alert-warning';
                            vm.searchCaption = 'Попробуйте другие варианты поиска.';
                        }
                    })
                    .catch(function (error) {
                        alert('Ошибка! Не могу связаться с API. Попробуйте заного.' + error);
                    });
            },

            getData: function (param, page) {
                this.searchCaption = "Ожидайте ответ...";
                let url = "";
                switch (param) {
                    case 'prev':
                        url += '&page=' + (this.paginateData.current_page - 1);
                        break;
                    case 'next':
                        url += '&page=' + (this.paginateData.current_page + 1);
                        break;
                    default :
                        url += '&page=' + page;
                        break;
                }
                this.uploadData(url);
            },
            dismissAlert: function () {
                this.finalCaption = "";
            }
        },
        mounted() {
            let vm = this;
            $('#createdAtField').datepicker({
                position: 'bottom left',
                autoClose: true,
                dateFormat: 'yyyy-mm-dd',
                range: true,
                toggleSelected: false,
                onSelect: function (fn, date) {
                    vm.createdAtField = fn;
                }
            });
        },
        updated() {
        }
    });
}

window.startAlert = function (vueObject, caption, type) {
    vueObject.finalCaption = caption;
    vueObject.finalCaptionClass = type;
    if (window.alertTImer) {
        clearTimeout(window.alertTImer);
    }
    window.alertTImer = setTimeout(() => {
        vueObject.dismissAlert();
    }, 5000);
};

if ($('#bodyD').length > 0) {
    tinymce.init({
        selector: '#bodyD'
    })
}

if ($("#testEditor").length > 0) {
    let testEditorInit = function (type) {
        let test = (phpToVueData.test) ? phpToVueData.test : false;
        switch (type) {
            case 'main':
                return (test) ? test : {
                    id: false,
                    title: "",
                    testable: false,
                    questions: []
                };

            case 'category':
                return (test)
                    ? (test.testable_type === 'App\\LectureCategory')
                        ? test.testable_id
                        : test.testable.lecture_category_id
                    : "";

            case 'lecture':
                return (test)
                    ? (test.testable_type === 'App\\LectureCategory')
                        ? ""
                        : test.testable_id
                    : "";
            case 'type':
                return (test)
                    ? (test.testable_type === 'App\\LectureCategory')
                        ? 1
                        : 2
                    : 1;
            default:
                return 'no_param';
        }
    };

    const testEditor = new Vue({
        el: '#testEditor',
        data: {
            categories: phpToVueData.categories,
            lectures: [],
            test: testEditorInit('main'),
            categoryField: testEditorInit('category'),
            lectureField: testEditorInit('lecture'),
            typeField: testEditorInit('type'),

            step: 1,
            finalCaption: "",
            serverErrors: [],

            createQuestion: false,
            questionTitle: "",
            toAddAnswers: [],
            answerInput: "",
            trueAnswer: false,
            editIndex: 0,
            modalType: "",
            editAnswerError: false
        },
        computed: {},
        watch: {
            categoryField: function () {
                axios({
                    method: 'get',
                    url: '/lectures/getByCategory/' + this.categoryField
                })
                    .then(response => {
                        this.lectures = response.data;
                        this.lectureField = "";
                    })
                    .catch(error => {
                        alert(error);
                        this.categoryField = "";
                    });
            }
        },
        mounted() {
            console.log('lister mounted');
        },
        methods: {
            moveToStep2: function () {
                let vm = this;
                vm.$validator.validateAll().then(result => {
                    if (!result) {
                        console.log('no validate');
                        return;
                    }
                    axios({
                        method: (!vm.test.id) ? 'post' : 'put',
                        url: '/tests' + ((!vm.test.id) ? "" : '/' + vm.test.id),
                        data: {
                            title: vm.test.title,
                            testable_id: (vm.typeField === 1) ? vm.categoryField : vm.lectureField,
                            testable_type: (vm.typeField === 1) ? "App\\LectureCategory" : "App\\Lecture"
                        }
                    })
                        .then(response => {
                            vm.step = 2;
                            vm.test = response.data;
                        })
                        .catch(error => {
                            switch (error.response.status) {
                                case 422:
                                    startAlert(vm, 'Ошибка валидации', 'warning');
                                    vm.serverErrors = error.response.data.errors;
                            }
                        });

                });
            },
            clearAnswerFields: function () {
                this.answerInput = "";
                this.trueAnswer = false;
                this.editAnswerError = false;
            },
            addQuestion: function () {
                this.createQuestion = !this.createQuestion;
                this.questionTitle = "";
                this.toAddAnswers = [];
            },
            addAnswer: function () {
                this.modalType = "createToAdd";
                $('#answerModal').modal('show');
            },
            cancelAddAnswer: function () {
                this.clearAnswerFields();
                $('#answerModal').modal('hide');
            },
            storeToAddAnswer: function () {
                let vm = this;
                this.$validator.validate('answerInput', vm.answerInput).then(result => {
                    if (!result) return;
                    if (this.trueAnswer) {
                        if (this.toAddAnswers.filter(item => {
                                return (item.trusted === true)
                            }).length > 0) {
                            this.editAnswerError = true;
                            return
                        }
                    }
                    this.toAddAnswers.push({
                        title: vm.answerInput,
                        trusted: vm.trueAnswer
                    });
                    $('#answerModal').modal('hide');
                    this.clearAnswerFields();
                });
            },
            editToAddAnswer: function (answer, index) {
                this.answerInput = answer.title;
                this.trueAnswer = answer.trusted;
                this.editIndex = index;
                this.modalType = "editToAdd";
                $('#answerModal').modal('show');
            },
            updateToAddAnswer: function () {
                let vm = this;
                this.$validator.validate('answerInput', vm.answerInput).then(result => {
                    if (!result) return;
                    if (this.trueAnswer) {
                        if (this.toAddAnswers.filter((item, index) => {
                                return (item.trusted === true && index !== this.editIndex)
                            }).length > 0) {
                            this.editAnswerError = true;
                            return
                        }
                    }
                    this.toAddAnswers.splice(this.editIndex, 1, {
                        title: vm.answerInput,
                        trusted: vm.trueAnswer
                    });
                    $('#answerModal').modal('hide');
                    this.clearAnswerFields();
                });
            },
            deleteToAddAnswer: function (index) {
                this.toAddAnswers.splice(index, 1);
            },
            uploadQuestion: function () {
                let vm = this;
                this.$validator.validateAll({
                    questionTitle: vm.questionTitle
                }).then(result => {
                    if (!result) return;
                    if (vm.toAddAnswers.length < 1) {
                        startAlert(vm, 'Добавьте ответы к вопросу', 'warning');
                        return;
                    }
                    if (vm.toAddAnswers.filter(item => {
                            return item.trusted
                        }).length === 0) {
                        startAlert(vm, 'Не указан правильный ответ для вопроса', 'warning');
                        return;
                    }
                    axios({
                        method: 'post',
                        url: '/questions',
                        data: {
                            title: vm.questionTitle,
                            test_id: vm.test.id,
                            answers: vm.toAddAnswers
                        }
                    })
                        .then(response => {
                            vm.test.questions.push(response.data);
                            vm.questionTitle = "";
                            vm.toAddAnswers = [];
                            vm.addQuestion();
                            startAlert(this, 'Вопрос сохранен', 'success');
                        })
                        .catch(error => {
                            switch (error.response.status) {
                                case 422:
                                    startAlert(vm, 'Ошибка валидации', 'warning');
                                    vm.serverErrors = error.response.data.errors;
                            }
                        });
                });
            },
            dismissAlert: function () {
                this.finalCaption = "";
            },
            disableErrors: function (index) {
                this.serverErrors.splice(index, 1);
            },
            deleteQuestion: function(question) {
                this.test.questions = this.test.questions.filter((item, index) => {
                    return (item.id !== question.id)
                })
            }
        }
    });
}
