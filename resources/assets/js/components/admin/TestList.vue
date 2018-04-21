<template>
    <div>
        <div class="" v-if="renderModels.length > 0">
            <div v-for="(modelNow, index) in renderModels" style="padding:10px 0;" class="row oneBlock">
                <div class="col-lg-12">
                    <div class="row">
                        <div style="text-align:center;" class="col-lg-1 mr-0 pr-0"><span
                                class="clientId align-middle text-primary">{{modelNow.id}}</span></div>
                        <div class="col-lg-3">
                            <span>{{modelNow.title}}</span>
                        </div>
                        <div class="col-lg-2">
                            <span v-if="modelNow.testable_type === 'App\\Lecture'">Лекционный</span>
                            <span v-else >Итоговый</span>
                        </div>
                        <div class="col-lg-3">
                            <span>{{modelNow.testable.title}}</span>
                        </div>
                        <div class="col-lg-1">
                            <span>{{modelNow.questions.length}}</span>
                        </div>
                        <div class="col-lg-2">
                            <a target="_blank" :href="'/tests/' + modelNow.id + '/edit'" class="btn btn-primary" style="padding:2px 6px;"
                                    title="Редактор теста"><i
                                    class="fa fa-edit"></i></a>
                            <button v-on:click="deleteModel(modelNow)" style="padding:2px 6px;"
                                    class="btn btn-default"><i class="fa fa-times" title="Удалить"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else style="text-align: center;">
            <span style="font-weight:800; font-size:14px;">Пустые параметры поиска!</span>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['tests'],
        data: function () {
            return {

            }
        },
        computed: {
            renderModels: function () {
                return this.tests;
            },
        },
        methods: {
            deleteModel: function (modelNow) {
                let vm = this;
                if (confirm('Вы хотите удалить тест с идентификатором № ' + modelNow.id)) {
                    axios({
                        method: 'delete',
                        url: '/tests/' + modelNow.id
                    })
                        .then(reponse => {
                            vm.$parent.deleteModel(modelNow);
                        })
                        .catch(error => {
                            startAlert(vm.$parent, 'Ошибка при удалении лекции. Перезагрузите стараницу.', 'danger');
                    });
                }
            }
        },
        updated() {

        }
    }
</script>
<style>
    .clientId {
        font-size: 22px;
    }

    .titleTable {
        color: black;
        font-weight: 800;
    }

    label {
        font-size: 10px;
        margin: 0;
    }

    .spanObjects {
        font-weight: 700;
    }

    .mainSpanObjects {
        margin-right: 10px;
    }

    .oneBlock:hover {
        background-color: #EDEFF2;
    }

    input.is-danger {
        border-color: darkred !important;
    }

    span.is-danger {
        color: darkred !important;
    }
</style>