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
            },
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
                    return (item.id !== model.id);
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
    let testEditorInit = function(){
        return (phpToVueData.test) ? phpToVueData.test : {
            id: false,
            title: "",
            testable: false,
            questions: []
        }
    };
    const testEditor = new Vue({
        el: '#testEditor',
        data: {
            categories: phpToVueData.categories,
            lectures: [],
            test: testEditorInit(),
            titleField: "",
            categoryField: "",
            lectureField: "",
            typeField: 1,
            step: 1,
            createQuestion: false,
            answerInput: "",
            questionTitle: "",
            toAddAnswers: [],
            trueAnswer: false,
            editIndex: 0,
            finalCaption: "",
            modalType: "",
            editAnswerError: false
        },
        watch: {
            categoryField: function () {
                if (this.typeField) {
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
            }
        },
        mounted() {
            console.log('lister mounted');
        },
        methods: {
            moveToStep2: function(){
                let vm = this;
                vm.$validator.validateAll().then(result=> {
                    if (!result) return;
                    axios({
                        method: (!vm.test.id) ? 'post' : 'put',
                        url: '/tests' + ((!vm.test.id) ? "" : vm.test.id),
                        data: {
                            title: vm.titleField,
                            testable_id: (vm.typeField === 1) ? vm.categoryField : vm.lectureField,
                            testable_type: (vm.typeField === 1) ? "App\\LectureCategory" : "App\\Lecture"
                        }
                    })
                        .then( response => {
                            vm.step = 2;
                        })
                        .catch( error => {
                            alert(error);
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
                this.$validator.validateAll().then(result=> {
                    if(!result) return;
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
                    startAlert(this, 'Ответ добавлен', 'success');
                    this.clearAnswerFields();
                    $('#answerModal').modal('hide');
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
                this.$validator.validateAll().then(result=> {
                    if(!result) return;
                    if (this.trueAnswer) {
                        if (this.toAddAnswers.filter((item, index) => {
                                return (item.trusted === true && index !== this.editIndex)
                            }).length > 0)  {
                            this.editAnswerError = true;
                            return
                        }
                    }
                    this.toAddAnswers.splice(this.editIndex, 1, {
                        title: vm.answerInput,
                        trusted: vm.trueAnswer
                    });
                    $('#answerModal').modal('hide');
                    startAlert(this, 'Ответ отредактирован', 'warning');
                    this.clearAnswerFields();
                });
            },
            deleteToAddAnswer: function (index) {
                this.toAddAnswers.splice(index, 1);
            },
            dismissAlert: function () {
                this.finalCaption = "";
            }
        }
    });
}
