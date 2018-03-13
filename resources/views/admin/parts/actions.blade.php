@role('admin')
    @if($resource->trashed())
        <form method="POST" class="pl-1" action="{{ route($resource_base_route.'.restore', ['id' => $resource->id]) }}">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-sm btn-success">Restore</button>
        </form>
        <form method="POST" class="pl-1" action="{{ route($resource_base_route.'.destroy.force', ['id' => $resource->id]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Destroy</button>
        </form>
    @else
        <form method="POST" class="pl-1" action="{{ route($resource_base_route.'.destroy', ['id' => $resource->id]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </form>
    @endif
@endrole