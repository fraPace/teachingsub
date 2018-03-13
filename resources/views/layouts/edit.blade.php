@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <span class="h4 align-middle">{{ __('Edit '.$resource_name) }}</span>
                    <div class="float-right d-inline-flex">
                        @include('admin.parts.actions', [
                            "resource" => $resource,
                            "resource_base_route" => "users"
                        ])
                    </div>
                </div>
                <div class="card-body">
                    @include('layouts.forms.edit', [
                        "resource" => $resource,
                        "resource_base_route" => $resource_base_route,
                    ])
                </div>
            </div>
            @yield('extra-forms')
        </div>
    </div>
</div>
@endsection
