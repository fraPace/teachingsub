<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{$id}}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{$id}}Label">{{ __('Edit '.$resource_name) }}</h5>
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                    {{--<span aria-hidden="true">&times;</span>--}}
                {{--</button>--}}
                <div class="pull-left d-inline-flex">
                    @include('admin.parts.actions', [
                        "resource" => $resource,
                        "resource_base_route" => $resource_base_route
                    ])
                </div>
            </div>

            <form method="POST" action="{{ route($resource_base_route.'.update', ['id' => $resource->id]) }}"  enctype="multipart/form-data">
                <input id="modal_id{{$id ?: ""}}" type="hidden" name="modal_id" value="{{ $id }}">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    @include($resource_base_route.'.forms.input.model')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>