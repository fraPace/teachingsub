<input id="name{{$id ?: ""}}" type="hidden" name="name" value="{{ $logged_user->name.'-'.$submission->assignment->tag }}" >

<input id="assignment_id{{$id ?: ""}}" type="hidden" name="assignment_id" value="{{ $submission->assignment->id }}">

<input id="user_id{{$id ?: ""}}" type="hidden" name="user_id" value="{{ $logged_user->id }}">

@include('layouts.forms.input.file', ["errors" => $errors])


