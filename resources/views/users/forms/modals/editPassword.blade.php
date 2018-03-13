<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{$id}}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{$id}}Label">{{ __('Change Password') }}</h5>
            </div>

            <form method="POST" action="{{ route($resource_base_route.'.updatePassword', ['id' => $resource->id]) }}"  enctype="multipart/form-data">
                <input id="modal_id{{$id ?: ""}}" type="hidden" name="modal_id" value="{{ $id }}">
                <div class="modal-body">
                    @csrf
                    @method('PUT')

                    @include($resource_base_route.'.forms.input.password', ["change" => true])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>