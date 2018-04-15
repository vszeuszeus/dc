
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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('lister-component', require('./components/admin/ListerComponent.vue'));
Vue.component('lecture-list', require('./components/admin/LectureList.vue'));

if($('#app').length > 0) {
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
            dismissAlert: function (){
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

window.startAlert = function(vueObject, caption, type){
    vueObject.finalCaption = caption;
    vueObject.finalCaptionClass = type;
    setTimeout(() => {
        vueObject.dismissAlert();
    }, 5000);
};

if($('#bodyD').length > 0) {
    tinymce.init({
        selector: '#bodyD'
    })
}


