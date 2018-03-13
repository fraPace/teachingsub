@php
    $id = 'users'.$user->id;
    $resource = $user;
    $resource_base_route = "users";
@endphp

@extends('layouts.edit', [
    "id" => $id,
    "resource" => $resource,
    "resource_base_route" => $resource_base_route,
    "resource_name" => "User",
    "extra_variables" => [
        "password" => true
    ]
])

@section('extra-forms')
    <div class="card">
        <div class="card-header">
            <span class="h4 align-middle">{{ __('Change Password ') }}</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route($resource_base_route.'.updatePassword', ['id' => $resource->id]) }}"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include($resource_base_route.'.forms.input.password', ["change" => true])
                <div class="form-group row mt-2 mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection