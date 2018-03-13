@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <span class="h4 align-middle">Upload Users</span>
                    <br>
                    Format: CSV | Schema: username,name,password,role | Optional Fields: email
                </div>

                <div class="card-body">
                    <form method='POST' action="{{ route('admin.upload.users')  }}" enctype="multipart/form-data">
                        @csrf

                        @include('layouts.forms.input.file', [
                            "id" => 'adminUploadUsers',
                            "errors" => $errors->users
                        ])

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{--<div class="card">--}}
                {{--<div class="card-header">--}}
                    {{--<span class="h4 align-middle">Upload Courses</span>--}}
                    {{--<br>--}}
                    {{--Format: CSV | Schema: name,tag,starts_at,ends_at,url,usernames | Optional Fields: url --}}
                {{--</div>--}}

                {{--<div class="card-body">--}}
                    {{--<form method='POST' action="{{ route('admin.upload.courses')  }}" enctype="multipart/form-data">--}}
                        {{--@csrf--}}

                        {{--@include('admin.parts.upload_file', ["errors" => $errors->courses])--}}

                        {{--<div class="form-group row mb-0">--}}
                            {{--<div class="col-md-8 offset-md-4">--}}
                                {{--<button type="submit" class="btn btn-primary">--}}
                                    {{--{{ __('Submit') }}--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
</div>
@endsection
