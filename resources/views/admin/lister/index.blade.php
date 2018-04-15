@extends('layouts.admin')

@section('content')
<div id="lister">
    <div v-if="finalCaption" style="z-index: 999999; position: fixed; top:10%; width:700px; right:5%;" >
        <div class="col-lg-12">
            <div :class="'alert alert-' + finalCaptionClass + ' alert-dismissible fade show'" role="alert">
                @{{finalCaption}}
                <button type="button" class="close" v-on:click="dismissAlert()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    <lister-component :list-data="listData" :model="model" :name="name"></lister-component>
</div>
@php echo "<script>var phpToVueData = ".json_encode($data).";</script>" @endphp
@endsection
