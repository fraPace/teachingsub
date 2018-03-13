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
@foreach($resources as $r)
    <tr class="{{ $r->trashed() ? 'bg-warning' : ''  }}">
        <td><a href="{{ route($resource_base_route.'.show', ['id' => $r->id]) }}">{{$r->username}}</a></td>
        <td>{{$r->name}}</td>
        <td>{{$r->email}}</td>
        <td>{{implode(",", $r->getRoleNames()->toArray())}}</td>
        <td class="flex-center">
            {{--<a class="btn btn-sm btn-primary" href="{{ route($resource_base_route.'.edit', ['id' => $r->id]) }}">Edit</a>--}}
            @if(!$r->trashed())
                @php
                    $modal_id = 'editModalPassword'.$resource_name.$r->id;
                @endphp
                <button type="button" class="btn btn-sm btn-warning float-right mr-1" data-toggle="modal" data-target="#{{ $modal_id }}">
                    {{ __('Reset Password') }}
                </button>
                @include($resource_base_route.".forms.modals.resetPassword", [
                    "resource" => $r,
                    "id" => $modal_id
                ])
                @php
                    $modal_id = 'editModal'.$resource_name.$r->id;
                @endphp
                <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#{{ $modal_id }}">
                    {{ __('Edit') }}
                </button>
                @include("layouts.forms.modals.edit", [
                    "resource" => $r,
                    "id" => $modal_id,
                    "password" => false
                ])
            @endif
            @include('admin.parts.actions', [
                "resource" => $r,
                "resource_base_route" => $resource_base_route
            ])
        </td>
    </tr>
@endforeach
</tbody>