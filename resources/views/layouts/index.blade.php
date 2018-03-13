@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-header align-middle">
                    <span class="h4 align-middle">{{__($resource_name_plural)}}</span>
                    @hasanyrole('admin|professor|ta')
                        {{--<a class="btn btn-sm btn-primary float-right" href="{{route($resource_base_route.'.create')}}">--}}
                            {{--{{ __('New '.$resource_name) }}--}}
                        {{--</a>--}}
                        @php
                            $modal_id = 'createModal'.$resource_name;
                        @endphp
                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#{{$modal_id}}">
                            {{ __('New '.$resource_name) }}
                        </button>
                        @include("layouts.forms.modals.create", [
                            "id" => $modal_id,
                            "password" => true
                        ])
                    @endrole
                </div>

                <div class="card-body table-responsive">
                    <table class="datatable table table-striped table-hover">
                        @include($resource_base_route.'.tables.index')
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
