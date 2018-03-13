@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <span class="h4 align-middle">{{ __('New '.$resource_name) }}</span>
                </div>
                <div class="card-body">
                    @include('layouts.forms.create', [
                        "resource" => $resource,
                        "resource_base_route" => $resource_base_route,
                        "extra_variables" => $extra_variables
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
