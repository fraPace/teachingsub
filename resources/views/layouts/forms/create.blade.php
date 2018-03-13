<form method="POST" action="{{ route($resource_base_route.'.store') }}"  enctype="multipart/form-data">
    @csrf
    @include($resource_base_route.'.forms.input.model', $extra_variables)
    <div class="form-group row mt-2 mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
    </div>
</form>