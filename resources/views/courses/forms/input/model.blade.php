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

<input type="hidden" name="user_id[{{$logged_user->id}}]" value="{{$logged_user->id}}" required>

{{--@role('admin')--}}
<div class="card">
    <div class="card-header">
        <a class="h4 align-middle" data-toggle="collapse" href="#collapseUsers{{$resource->id}}" aria-expanded="true" aria-controls="collapseUsers{{$resource->id}}">
            Users
        </a>
    </div>

    <div id="collapseUsers{{$resource->id}}" class="collapse">
        <div class="card-body table-responsive">
            <table class="datatable-select-checkbox table table-striped table-hover">
                <thead class="">
                    <tr>
                        <th scope="col">{{__('Select')}}</th>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('Role')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $role=>$user)
                        @foreach($user as $u)
                            <tr id="{{$u->id}}">
                                <td><input name="user_id[{{$u->id}}]" class="" type="checkbox" id="checkbox{{$u->id}}" value="{{$u->id}}" {{ old('user_id.'.$u->id, isset($resource->usersById[$u->id])) ? 'checked' : '' }}></td>
                                <td>{{$u->name}}</td>
                                <td>{{$role}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


