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
                        @include('courses.tables.information',[
                            "resource" => $course,
                            "resource_name" => 'Course',
                            "resource_base_route" => 'courses'
                        ])

                        <div class="card">
                            <div class="card-header align-middle">
                                <a class="h5 align-middle" data-toggle="collapse" href="#collapseParticipants" aria-expanded="true" aria-controls="collapseParticipants">
                                    {{__('Participants')}}
                                </a>
                            </div>
                            <div id="collapseParticipants" class="collapse">
                                <div class="card-body table-responsive">
                                    @include('courses.tables.participants',[
                                        "resources" => $course->users,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header align-middle">
                    <span class="h4 align-middle">Assignments</span>
                    @hasanyrole('admin|professor|ta')
                        @php
                            $modal_id = 'editModalAssignment';
                        @endphp
                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#{{$modal_id}}">
                            {{ __('New Assignment') }}
                        </button>
                        @include("layouts.forms.modals.create", [
                            "id" => $modal_id,
                            "resource_name" => 'Assignment',
                            "resource_base_route" => 'assignments',
                            "resource" => $assignment
                        ])
                    @endrole
                </div>

                <div class="card-body table-responsive">
                    @include('assignments.tables.index', [
                        'courseShow' => false,
                        'resources' => $course->assignments,
                        "resource_base_route" => 'assignments',
                        "resource_name" => 'Assignment'
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
