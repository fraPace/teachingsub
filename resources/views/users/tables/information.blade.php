<table class="table table-striped table-hover">
    <thead class="">
    <tr>
        <th scope="col">{{ __('Username') }}</th>
        <th scope="col">{{ __('Name') }}</th>
        <th scope="col">{{ __('Email') }}</th>
        <th scope="col">{{ __('Roles') }}</th>
        <th scope="col">{{ __('Actions') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr class="{{ $resource->trashed() ? 'bg-warning' : ''  }}">
        <td>{{$resource->username}}</td>
        <td>{{$resource->name}}</td>
        <td>{{$resource->email}}</td>
        <td>{{implode(",", $resource->getRoleNames()->toArray())}}</td>
        <td class="flex-center">
            {{--<a class="btn btn-sm btn-primary" href="{{ route($resource_base_route.'.edit', ['id' => $r->id]) }}">Edit</a>--}}
            @if(!$resource->trashed())
                @php
                    $modal_id = 'editModalPassword'.$resource_name.$resource->id;
                @endphp
                <button type="button" class="btn btn-sm btn-warning float-right mr-1" data-toggle="modal" data-target="#{{ $modal_id }}">
                    {{ __('Reset Password') }}
                </button>
                @include($resource_base_route.".forms.modals.resetPassword", [
                    "resource" => $resource,
                    "id" => $modal_id
                ])
                @php
                    $modal_id = 'editModal'.$resource_name.$resource->id;
                @endphp
                <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#{{ $modal_id }}">
                    {{ __('Edit') }}
                </button>
                @include("layouts.forms.modals.edit", [
                    "resource" => $resource,
                    "id" => $modal_id,
                    "password" => false
                ])
            @endif
            @include('admin.parts.actions', [
                "resource" => $resource,
                "resource_base_route" => $resource_base_route
            ])
        </td>
    </tr>
    </tbody>
</table>