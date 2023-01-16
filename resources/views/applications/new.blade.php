@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Ready to get started?</h6>
        </div>
        <div class="card-body">
            <form id="application_form" action="{{ url('/applications/store') }}" method="POST">
                <div class="form-row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Name<sup class="mandatory">*</sup></label>
                            <input type="text" autocomplete="off" class="form-control" placeholder="Enter name"
                                name="name">
                            <span class="help-block name-error"></span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="form-group">
                            <label for="language" class="control-label">Language<sup class="mandatory">*</sup></label>
                            @php $applicationLanguages = config('constants.APPLICATION_LANGUAGES') @endphp
                            <select name="language" class="custom-select form-control">
                                <option value="0" selected>Please select</option>
                                @foreach($applicationLanguages as $key => $language)
                                <option value="{{ $language }}">{{ $language }}</option>
                                @endforeach
                            </select>
                            <span class="help-block language-error"></span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="form-group">
                            <label for="framework" class="control-label">Framework<sup class="mandatory">*</sup></label>
                            @php $applicationFrameworks = config('constants.APPLICATION_FRAMEWORKS') @endphp
                            <select name="framework" class="custom-select form-control">
                                <option value="0" selected>Please select</option>
                                @foreach($applicationFrameworks as $key => $framework)
                                <option value="{{ $framework }}">{{ $framework }}</option>
                                @endforeach
                            </select>
                            <span class="help-block framework-error"></span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12">
                        <br>
                        <h5 class="mb-4"> Server details </h5>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="form-group">
                            <label for="username" class="control-label">Username<sup class="mandatory">*</sup></label>
                            <input type="text" autocomplete="off" class="form-control" placeholder="Enter user name"
                                name="username">
                            <span class="help-block username-error"></span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="form-group">
                            <label for="host" class="control-label">Host<sup class="mandatory">*</sup></label>
                            <input type="text" autocomplete="off" class="form-control" placeholder="Enter host"
                                name="host">
                            <span class="help-block host-error"></span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="form-group">
                            <label for="password" class="control-label">Password<sup class="mandatory">*</sup></label>
                            <input type="password" autocomplete="off" class="form-control" placeholder="Enter password"
                                name="password">
                            <span class="help-block password-error"></span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12">
                        <div class="form-group">
                            <label for="path" class="control-label">Path<sup class="mandatory">*</sup></label>
                            <input type="text" autocomplete="off" class="form-control" placeholder="Enter path"
                                name="path">
                            <span class="help-block path-error"></span>
                        </div>
                    </div>
                </div>
                <strong><span class="help-block connect-error"></span></strong>
                <br>
                <div class="col-sm-12 mt-3">
                    <div class="row">
                        <div class="text-left">
                            <a href="{{ url('/') }}" class="btn btn-secondary btn-icon-split"><span
                                    class="icon text-white">
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                                <span class="text">Back</span>
                            </a>
                            <button class="btn btn-primary btn-icon-split" onclick="submitForm(this)"
                                data-redirect="{{ url('/') }}" data-servercall="call" type="button"><span
                                    class="icon text-white">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Save</span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection