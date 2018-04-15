@extends('layouts.admin')

@section('content')
    <div id="lectures" class="container">
        <div v-if="finalCaption" style="z-index: 999999; position: fixed; top:5%; width:400px; right:5%;" >
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
            <div class="col-lg-12">
                <div class="card">
                    <div id="">
                        <div class="card-header">Лекции</div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <a class="btn btn-primary mb-1" href="{{route('lectures.create')}}"><i
                                                class="fa fa-plus"></i> Добавить лекцию</a>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-header">Фильтры и поиск</div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-lg-4">
                                            <input v-model="titleField" id="titleField" type="text" class="form-control"
                                                   placeholder="Поиск по названию">
                                        </div>
                                        <div class="col-lg-4">
                                            <input v-model="createdAtField" id="createdAtField" type="text" class="form-control"
                                                   placeholder="Поиск по Дате создания">
                                        </div>
                                        <div class="col-lg-4">
                                            <select class="form-control" v-model="categoryField">
                                                <option value="">Поиск по категории</option>
                                                <option v-for="category in categories" :value="category.id">@{{ category.title }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p :class="searchCaptionClases">@{{searchCaption}}</p>
                            <lection-list :lections="lections"></lection-list>
                            <template v-if="((paginateData.total > paginateData.per_page) && (paginateData.total > 0))">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ul class="pagination">
                                            <li v-if="paginateData.current_page === 1" class="">
                                                <button class="btn btn-primary" disabled>&laquo;</button>
                                            </li>
                                            <li v-else>
                                                <button class="btn btn-primary" v-on:click="getData('prev', false)">
                                                    &laquo;
                                                </button>
                                            </li>
                                            <template v-for="index in paginateData.last_page">
                                                <template v-if="index === paginateData.current_page">
                                                    <li class="">
                                                        <button class="btn-btn-default" disabled>@{{ index }}</button>
                                                    </li>
                                                </template>
                                                <template v-else>
                                                    <li>
                                                        <button class="btn-btn-default"
                                                                v-on:click="getData(false, index)">@{{ index }}
                                                        </button>
                                                    </li>
                                                </template>
                                            </template>
                                            <li v-if="paginateData.current_page < paginateData.last_page">
                                                <button class="btn btn-primary"
                                                        v-on:click="getData('next', false)">&raquo;
                                                </button>
                                            </li>
                                            <li v-else>
                                                <button class="btn btn-primary" disabled>&raquo;</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php echo "<script> var backToFront=" . json_encode($backToFront) . "</script>"; @endphp;
@endsection
