<table class="table table-striped table-hover">
    <thead class="">
    <tr>
        <th scope="col">{{ __('Name') }}</th>
        <th scope="col">{{ __('Tag') }}</th>
        <th scope="col">{{ __('URL') }}</th>
        <th scope="col">{{ __('Starts') }}</th>
        <th scope="col">{{ __('Ends') }}</th>
        @role('admin|professor|ta')
            <th scope="col">{{ __('Actions') }}</th>
        @endrole
    </tr>
    </thead>
    <tbody>
    <tr class="{{ $resource->trashed() ? 'bg-warning' : ''  }}">
        <td>{{$resource->name}}</td>
        <td>{{$resource->tag}}</td>
        <td><a href="{{ $resource->url }}">Link</a></td>
        <td>{{$resource->startsAt()}}</td>
        <td>{{$resource->endsAt()}}</td>
        @role('admin|professor|ta')
            <td class="flex-center">
                @if(!$resource->trashed())
                    {{--<a class="btn btn-sm btn-primary" href="{{ route($resource_base_route.'.edit', ['id' => $r->id]) }}">Edit</a>--}}
                    @php
                        $modal_id = 'editModal'.$resource_name.$resource->id;
                    @endphp
                    <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#{{ $modal_id }}">
                        {{ __('Edit') }}
                    </button>
                    @include("layouts.forms.modals.edit", [
                        "resource" => $resource,
                        "id" => $modal_id
                    ])
                @endif
                @include('admin.parts.actions', [
                    "resource" => $resource,
                    "resource_base_route" => $resource_base_route
                ])
            </td>
        @endrole
    </tr>
    </tbody>
</table>