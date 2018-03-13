<table class="datatable table table-striped table-hover">
    <thead class="">
    <tr>
        <th scope="col">{{ __('Name') }}</th>
        <th scope="col">{{ __('Tag') }}</th>
        <th scope="col">{{ __('URL') }}</th>
        @if($courseShow)
            <th scope="col">{{ __('Course') }}</th>
        @endif
        <th scope="col">{{ __('Starts') }}</th>
        <th scope="col">{{ __('Ends') }}</th>
        @role('admin|professor|ta')
            <th scope="col">{{ __('Actions') }}</th>
        @endrole
    </tr>
    </thead>
    <tbody>
    @foreach($resources as $r)
        <tr class="{{ $r->trashed() ? 'bg-warning' : ''  }}">
            <td><a href="{{ route($resource_base_route.'.show', ['id' => $r->id]) }}">{{$r->name}}</a></td>
            <td>{{$r->tag}}</td>
            <td><a href="{{ $r->url }}">Link</a></td>
            @if($courseShow)
                <td><a href="{{ route('courses.show', ['id' => $r->course->id]) }}">{{$r->course->name}}</a></td>
            @endif
            <td>{{$r->startsAt()}}</td>
            <td>{{$r->endsAt()}}</td>
            @role('admin|professor|ta')
                <td class="flex-center">
                    @if(!$r->trashed())
                        {{--<a class="btn btn-sm btn-primary" href="{{ route($resource_base_route.'.edit', ['id' => $r->id]) }}">{{ __('Edit') }}</a>--}}
                        @php
                            $modal_id = 'editModal'.$resource_name.$r->id;
                        @endphp
                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#{{ $modal_id }}">
                            {{ __('Edit') }}
                        </button>
                        @include("layouts.forms.modals.edit", [
                            "resource" => $r,
                            "resource_name" => 'Assignment',
                            "id" => $modal_id
                        ])
                    @endif
                    @include('admin.parts.actions', [
                        "resource" => $r,
                        "resource_base_route" => $resource_base_route
                    ])
                </td>
            @endrole
        </tr>
    @endforeach
    </tbody>
</table>
