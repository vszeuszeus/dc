<template>
    <div>
        <div class="" v-if="renderModels.length > 0">
            <div v-for="(modelNow, index) in renderModels" style="padding:10px 0;" class="row oneBlock">
                <div class="col-lg-12">
                    <div class="row">
                        <div style="text-align:center;" class="col-lg-1 mr-0 pr-0"><span
                                class="clientId align-middle text-primary">{{modelNow.id}}</span></div>
                        <div class="col-lg-4">
                            <span>{{modelNow.title}}</span>
                        </div>
                        <div class="col-lg-3">
                            <span>{{modelNow.category.title}}</span>
                        </div>
                        <div class="col-lg-2">
                            <span>{{modelNow.created_at}}</span>
                        </div>
                        <div class="col-lg-2">
                            <a target="_blank" :href="'/lectures/' + modelNow.id" class="btn btn-primary" style="padding:2px 6px;"
                               title="Открыть"><i
                                    class="fa fa-external-link"></i></a>
                            <a target="_blank" :href="'/lectures/' + modelNow.id + '/edit'" class="btn btn-primary" style="padding:2px 6px;"
                                    title="Редактировать"><i
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
            <span style="font-weight:800; font-size:14px;">Пустые параметры поиска!!</span>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['lectures'],
        data: function () {
            return {}
        },
        computed: {
            renderModels: function () {
                return this.lectures;
            },
        },
        methods: {
            deleteModel: function (modelNow) {
                let vm = this;
                if (confirm('Вы хотите удалить клиента с идентификатором № ' + modelNow.id)) {
                    axios({
                        method: 'delete',
                        url: '/lectures/' + modelNow.id
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