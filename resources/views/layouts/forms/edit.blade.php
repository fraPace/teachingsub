<form method="POST" action="{{ route($resource_base_route.'.update', ['id' => $resource->id]) }}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include($resource_base_route.'.forms.input.model')
    <div class="form-group row mt-2 mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
    </div>
</form>