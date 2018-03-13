<div class="form-group row">
    <label for="username{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

    <div class="col-md-6">
        <input id="username{{$id ?: ""}}" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username', $resource->username) }}" required autofocus>

        @if ($errors->has('username'))
            <span class="invalid-feedback">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="name{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

    <div class="col-md-6">
        <input id="name{{$id ?: ""}}" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $resource->name) }}" required>

        @if ($errors->has('name'))
            <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="email{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

    <div class="col-md-6">
        <input id="email{{$id ?: ""}}" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $resource->email) }}">

        @if ($errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>

@if(isset($password) and $password)
    @include('users.forms.input.password')
@endif

@role('admin')
    <div class="form-group row">
        <label for="role{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

        <div class="col-md-6">
            <select id="role{{$id ?: ""}}" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" required>
                @php
                    $role = $resource->roles->first();
                    if(isset($role)){
                    $old_role = $role->id;
                    }else{
                        $old_role = "";
                    }
                @endphp
                @foreach($roles as $role)
                    <option value="{{$role->name}}" {{ old('role', $old_role) == $role->id ? 'selected' : ''}}>{{$role->name}}</option>
                @endforeach
            </select>

            @if ($errors->has('role'))
                <span class="invalid-feedback">
                        <strong>{{ $errors->first('role') }}</strong>
                    </span>
            @endif
        </div>
    </div>
@endrole