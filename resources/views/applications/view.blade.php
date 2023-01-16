@extends('layouts.app')
@section('content')
<div class="container-fluid">
    @if($data['server_connect'] == 0)
    <div class="alert alert-danger bg-danger text-white shadow">
        <strong>Connection could not be established. Please check server details. </strong>
    </div>
    @endif
    <div class="card shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <form action="{{ url('/applications/update') }}" name="" id="application-view-form" method="post">
                    <input type="hidden" id="id" name="id" value="{{$data['id']}}">
                    <div class="form-row mb-3">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="name" class="control-label">Name<sup class="mandatory">*</sup></label>
                                <input type="text" class="form-control" placeholder="Enter name" id="name" name="name"
                                    value="{{$data['name']}}">
                                <span class="help-block name-error"></span>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="form-group">
                                <label for="language" class="control-label">Language<sup
                                        class="mandatory">*</sup></label>
                                @php $applicationLanguages = config('constants.APPLICATION_LANGUAGES') @endphp
                                <select name="language" class="custom-select form-control" id="language">
                                    <option value="0" selected>Please select</option>
                                    @foreach($applicationLanguages as $key => $language)
                                    <option {{ $language == $data['language'] ? 'selected' : '' }}
                                        value="{{ $language }}">
                                        {{ $language }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block language-error"></span>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="form-group">
                                <label for="framework" class="control-label">Framework<sup
                                        class="mandatory">*</sup></label>
                                @php $applicationFrameworks = config('constants.APPLICATION_FRAMEWORKS') @endphp
                                <select name="framework" class="custom-select form-control" id="framework">
                                    <option value="0" selected>Please select</option>
                                    @foreach($applicationFrameworks as $key => $framework)
                                    <option {{ $framework == $data['framework'] ? 'selected' : '' }}
                                        value="{{ $framework }}">{{ $framework }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block framework-error"></span>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="form-group">
                                <label for="username" class="control-label">Username<sup
                                        class="mandatory">*</sup></label>
                                <input type="text" class="form-control" placeholder="Enter user name" id="username"
                                    name="username" value="{{$data['username']}}">
                                <span class="help-block username-error"></span>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="form-group">
                                <label for="host" class="control-label">Host<sup class="mandatory">*</sup></label>
                                <input type="text" class="form-control" placeholder="Enter host" id="host" name="host"
                                    value="{{$data['host']}}">
                                <span class="help-block host-error"></span>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="form-group">
                                <label for="password" class="control-label">Password<sup
                                        class="mandatory">*</sup></label>
                                <input type="password" class="form-control" placeholder="Enter password" id="password"
                                    name="password" value="{{$data['password']}}">
                                <span class="help-block password-error"></span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12">
                            <div class="form-group">
                                <label for="path" class="control-label">Path<sup class="mandatory">*</sup></label>
                                <input type="text" class="form-control" placeholder="Enter path" id="path" name="path"
                                    value="{{$data['path']}}">
                                <span class="help-block path-error"></span>
                            </div>
                        </div>
                        <strong><span class="help-block connect-error"></span></strong>
                    </div>
                    <div class="text-left">
                        <button type="button" class="btn btn-secondary btn-icon-split"
                            data-url="{{ url('/applications/delete') }}" onclick="deletefunc(this)"
                            data-id="{{$data['id']}}" data-tooltip="true" data-placement="bottom"
                            data-message="Application deleted successfully"
                            data-redirect="{{ url('/') }}"><span class="icon text-white">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Delete</span></button>
                        <!-- <button class="btn btn-success update-application" data-modal="application-view-modal"
                        data-form="application-view-form" data-id="{{$data['id']}}" type="button">Update</button> -->
                        <button class="btn btn-primary btn-icon-split" onclick="submitForm(this)" data-alert="alert"
                            data-servercall="call" type="button"><span class="icon text-white">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">save</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection