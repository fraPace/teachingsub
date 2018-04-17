@role('admin|professor|ta')
    <div class="form-group row">
        <label for="name{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

        <div class="col-md-6">
            <input id="name{{$id ?: ""}}" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', isset($resource->name) ?  $resource->name : $logged_user->name.'-'.$submission->assignment->tag) }}" required>

            @if ($errors->has('name'))
                <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="user_id{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('User') }}</label>

        <div class="col-md-6">
            <select id="user_id{{$id ?: ""}}" class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}" name="user_id" required>
                @php
                    if(isset($resource->user)){
                        $old_user = $resource->user;
                    }else{
                        $old_user = $logged_user;
                    }
                @endphp
                @foreach($users as $user)
                    <option value="{{$user->id}}" {{ old('user_id', $old_user->id) == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                @endforeach
            </select>

            @if ($errors->has('user_id'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endrole

@role('student')
    <input id="name{{$id ?: ""}}" type="hidden" name="name" value="{{ $logged_user->name.'-'.$submission->assignment->tag }}" >
    <input id="user_id{{$id ?: ""}}" type="hidden" name="user_id" value="{{ $logged_user->id }}">
@endrole

<input id="assignment_id{{$id ?: ""}}" type="hidden" name="assignment_id" value="{{ $submission->assignment->id }}">

@include('layouts.forms.input.file', ["errors" => $errors])


