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
                        @include('assignments.tables.information',[
                            "resource" => $assignment,
                            "resource_name" => 'Assignment',
                            "resource_base_route" => 'assignments'
                        ])
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header align-middle">
                    <span class="h4 align-middle">{{__('Submissions')}}</span>
                    <div class="float-right">
                        @if($allow_new_submission)
                            {{--<a class="btn-sm btn-primary float-right ml-1" href="{{route('submissions.create.assignment', ["id" => $assignment->id])}}">--}}
                            {{--{{ __('New Submission') }}--}}
                            {{--</a>--}}
                            @php
                                $modal_id = 'createModalSubmission';
                            @endphp
                            <button type="button" class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target="#{{$modal_id}}">
                                {{ __('New Submission') }}
                            </button>
                            @include("layouts.forms.modals.create", [
                                "id" => $modal_id,
                                "resource_name" => 'Submission',
                                "resource_base_route" => 'submissions',
                                "resource" => $submission
                            ])
                        @endif
                        @role('admin|professor|ta')
                        <a class="btn btn-sm btn-info" href="{{route('assignments.download', ["id" => $assignment->id])}}">
                            {{ __('Download All') }}
                        </a>
                        @endrole
                    </div>
                </div>
                <div class="card-body table-responsive">
                    @include('submissions.tables.index', [
                        'resources' => $assignment->submissions,
                        "resource_base_route" => 'submissions',
                        "resource_name" => 'Submission'
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
