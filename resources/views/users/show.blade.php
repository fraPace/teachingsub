@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-header align-middle">
                    <a class="h4 align-middle" data-toggle="collapse" href="#collapseInformation" aria-expanded="true" aria-controls="collapseInformation">
                        {{__('Information')}}
                    </a>
                </div>

                <div id="collapseInformation" class="collapse">
                    <div class="card-body table-responsive">
                        @include('users.tables.information',[
                            "resource" => $user,
                            "resource_name" => 'User',
                            "resource_base_route" => 'users'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
