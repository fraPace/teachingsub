@if(isset($change) && $change)
    <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
        <div class="form-group row">
            <label for="current-password{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">Current Password</label>
            <div class="col-md-6">
                <input id="current-password{{$id ?: ""}}" type="password" class="form-control{{ $errors->has('current-password') ? ' is-invalid' : '' }}" name="current-password" required>

                @if ($errors->has('current-password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('current-password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
@endif

<div class="form-group row">
    <label for="password{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

    <div class="col-md-6">
        <input id="password{{$id ?: ""}}" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

        @if ($errors->has('password'))
            <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="password-confirm{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

    <div class="col-md-6">
        <input id="password-confirm{{$id ?: ""}}" type="password" class="form-control" name="password_confirmation" required>
    </div>
</div>