<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header" style="font-size:18px;">Справочник - {{name}}</div>

                    <div class="card-body">
                        <div v-for="(error, index) in titleErrors"
                             class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{error}}
                            <button type="button" class="close" v-on:click="disableErrors(index)" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <input v-model="inputTitle" type="text" class="form-control"
                                           placeholder="Наименование">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" v-on:click="addList()" class="btn btn-primary"><i
                                            class="fa fa-plus"> Добавить</i></button>
                                </div>
                            </div>
                        </form>
                        <div class="">
                            <div class="col-md-7">
                                <p style="font-size:16px;" class="pt-2 mb-1">Список:</p>
                                <template v-if="listData.length > 0">
                                    <div v-for="(oneData,index) in listDataP" class="row">
                                        <div class="col-md-1">
                                            <p>{{(index + 1)}}</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p>{{oneData.title}}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <button v-on:click="editList(oneData)"
                                                    class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
                                            <button v-on:click="deleteList(oneData)"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <p class="pt-0 mt-0">Список пуст!</p>
                                </template>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Редактирование записи</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <input type="text" v-model="toEditTitle" class="form-control mb-1"
                                                   placeholder="Наименование">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена
                                        </button>
                                        <button v-on:click="updateList()" type="button" class="btn btn-primary">
                                            Сохранить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        props: ['listData', 'model', 'name'],
        data: function () {
            let vm = this;
            console.log(this);
            return {
                listDataP: vm.listData,
                inputTitle: "",
                toEditTitle: "",
                toEditId: 1,
                titleErrors: []
            }
        },
        methods: {
            addList: function () {
                let vm = this;
                let url = '/' + this.model;
                axios({
                    method: "post",
                    url: url,
                    data: {
                        title: vm.inputTitle
                    }
                })
                    .then(response => {
                        vm.listDataP.push(response.data);
                        vm.inputTitle = "";
                        startAlert(vm.$parent, 'Справочник ' + vm.name + ' добавлен', 'success');
                    })
                    .catch(error => {
                        switch (error.response.status) {
                            case 422:
                                vm.titleErrors = error.response.data.errors.title;
                                startAlert(vm.$parent, 'Ошибка ввода', 'danger');
                        }
                    })
            },
            editList: function (oneData) {
                this.toEditTitle = oneData.title;
                this.toEditId = oneData.id;
                $('#modalEdit').modal('show');
            },
            updateList: function () {
                let vm = this;
                let url = '/' + vm.model + '/' + vm.toEditId;
                axios({
                    method: 'put',
                    url: url,
                    data: {
                        title: vm.toEditTitle
                    }
                })
                    .then(response => {
                        vm.listDataP.push(response.data);
                        vm.inputTitle = "";
                        startAlert(vm.$parent, 'Справочник ' + vm.name + ' отредактирован', 'success');
                    })
                    .catch(error => {
                        switch (error.response.status) {
                            case 422:
                                vm.titleErrors = error.response.data.errors.title;
                                startAlert(vm.$parent, 'Ошибка ввода', 'danger');
                        }
                    });
                $('#modalEdit').modal('hide');
            },
            deleteList: function (oneData) {
                let vm = this;
                let url = '/' + vm.model + '/' + oneData.id;
                if (confirm('Вы действительно хотите удалить запись с наименованием - "' + oneData.title + '" ?')) {
                    axios({
                        method: 'delete',
                        url: url
                    })
                        .then(response => {
                            vm.listDataP = vm.listDataP.filter(item => {
                                return (item.id !== oneData.id);
                            });
                            startAlert(vm.$parent, 'Запись удалена из справочника', 'success');
                        })
                        .catch(error => {
                            switch (error.response.status) {
                                case 404:
                                    vm.titleErrors = error.response.data.errors.title;
                                    startAlert(vm.$parent, 'Было удалено', 'warning');
                            }
                        })
                }
            },
            disableErrors: function (index = false) {
                if (index === false) {
                    this.titleErrors = [];
                } else {
                    this.titleErrors.splice(index, 1);
                }
            }
        }
    }
</script>
