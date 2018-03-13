<table class="datatable table table-striped table-hover">
    <thead class="">
    <tr>
        <th scope="col">{{__('User Name')}}</th>
        <th scope="col">{{__('Submitted')}}</th>
        <th scope="col">{{__('Actions')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($resources as $r)
        <tr class="{{ $r->trashed() ? 'bg-warning' : ''  }}">
            <td>{{$r->user->name}}</td>
            <td>{{$r->updated_at ?: $r->created_at}}</td>
            <td class="flex-center pull-left">
                <a class="btn btn-sm btn-info mr-1" href="{{ route($resource_base_route.'.download', ['id' => $r->id]) }}">{{ __('Download') }}</a>
                @role('admin|student')
                    @if(!$r->trashed())
                        @php
                            $modal_id = 'editModal'.$resource_name.$r->id;
                        @endphp
                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#{{ $modal_id }}">
                            {{ __('Edit') }}
                        </button>
                        @include("layouts.forms.modals.edit", [
                            "resource" => $r,
                            "resource_name" => $resource_name,
                            "id" => $modal_id
                        ])
                    @endif
                    @include('admin.parts.actions', [
                        "resource" => $r,
                        "resource_base_route" => $resource_base_route
                    ])
                @endrole
            </td>
        </tr>
    @endforeach
    </tbody>
</table>