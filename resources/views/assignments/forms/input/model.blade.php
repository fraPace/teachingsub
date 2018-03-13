<div class="form-group row">
    <label for="name{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

    <div class="col-md-6">
        <input id="name{{$id ?: ""}}" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $resource->name) }}" required autofocus>

        @if ($errors->has('name'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="tag{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('Tag') }}</label>

    <div class="col-md-6">
        <input id="tag{{$id ?: ""}}" type="text" class="form-control{{ $errors->has('tag') ? ' is-invalid' : '' }}" name="tag" value="{{ old('tag', $resource->tag) }}" required maxlength="5">

        @if ($errors->has('tag'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('tag') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="url{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('URL') }}</label>

    <div class="col-md-6 input-group">
        <input id="url{{$id ?: ""}}" type="text" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" value="{{ old('url', $resource->url) }}">
        @if ($errors->has('url'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('url') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="starts_at{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('Starts') }}</label>

    <div class="col-md-6 input-group">
        <input id="starts_at{{$id ?: ""}}" type="date" class="form-control{{ $errors->has('starts_at') ? ' is-invalid' : '' }}" name="starts_at" value="{{ old('starts_at', $resource->startsAt()) }}" required>
        @if ($errors->has('starts_at'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('starts_at') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="ends_at{{$id ?: ""}}" class="col-md-4 col-form-label text-md-right">{{ __('Ends') }}</label>

    <div class="col-md-6 input-group">
        <input id="ends_at{{$id ?: ""}}" type="date" class="form-control{{ $errors->has('ends_at') ? ' is-invalid' : '' }}" name="ends_at" value="{{ old('ends_at', $resource->endsAt()) }}" required>

        @if ($errors->has('ends_at'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('ends_at') }}</strong>
            </span>
        @endif
    </div>
</div>

<input type="hidden" name="course_id" value="{{ $resource->course->id }}">

{{--<div class="form-group row">--}}
    {{--<label for="course_id" class="col-md-4 col-form-label text-md-right">Course</label>--}}
    {{--<div class="col-md-6 input-group">--}}
        {{--<select id="course_id" class="form-control" name="course_id">--}}
            {{--@foreach($courses as $course)--}}
                {{--<option value="{{$course->id}}" {{old('course_id', isset($assignment->course->id) && ($assignment->course->id === $course->id)) ? 'selected' : ''  }}>{{$course->name}}</option>--}}
            {{--@endforeach--}}
        {{--</select>--}}
    {{--</div>--}}
{{--</div>--}}


