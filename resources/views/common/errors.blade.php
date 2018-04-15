@if (count($errors) > 0)
    <!-- Список ошибок формы -->

    <div>
        @foreach ($errors->all() as $error)
            <div class="col-lg-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endif