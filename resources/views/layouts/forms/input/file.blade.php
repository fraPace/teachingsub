<div class="form-group row">
    <label for="file{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('Input File') }}</label>

    <div class="col-md-6">
        <input id="file{{$id ?: ""}}" type="file" class="form-control{{ count($errors) == 0 ? '' : ' is-invalid' }}" name="file" required>
        @foreach ($errors->keys() as $key)
            <span class="invalid-feedback">
                <strong>{{ $errors->first($key) }} </strong>
            </span>
        @endforeach
    </div>
</div>