<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Topbar Search -->
    @if (count($apps))
    <div class="col-3">
        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <select type="text" class="form-control bg-light border-0 small app-select" id="app-selector"
                    name="app-selector" aria-label="Search">
                    @foreach ($apps as $app)
                    <option {{ session('selected_project') == $app->id ? 'selected' : '' }} value="{{ $app->id }}">
                        {{ $app->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <div class="col-3">
        <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 bg-light border-0 small">
            <a class="btn btn-primary btn-icon-split" href="/applications/new">
                <span class="icon text-white">
                     <i class="fas fa-fw fa-plus"></i>
                   </span>
                   <span class="text">New Application</span>
            </a>
        </div>
    </div>
    @endif
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->name}}</span>
                <i class="fa fa-user" aria-hidden="true"></i>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#myprofile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- My profile Modal-->
<div class="modal fade" id="myprofile" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Profile</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="{{ url('/user/update') }}" name="user-edit-form" id="user-edit-form-id"
                processData="false" , contentType="false" class="form-edit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="control-label">Name-</label>
                            <input type="name" class="form-control form-control-user" id="name" aria-describedby="name"
                                name="name" value="{{Auth::user()->name}}">
                            <div class="help-block with-errors name-error">
                                <span class="help-block"><strong>
                                        <p></p>
                                    </strong></span>
                            </div>

                        </div>
                        <div class="col-sm-12">
                            <label class="control-label">Email-</label>
                            <input type="email" class="form-control form-control-user" id="email"
                                aria-describedby="email" name="email" value="{{Auth::user()->email}}">
                            <div class="help-block with-errors email-error">
                                <span class="help-block"><strong>
                                        <p></p>
                                    </strong></span>
                            </div>

                        </div>
                        <div class="col-sm-12">
                            <label class="control-label">Company-</label>
                            <input type="company" class="form-control form-control-user" id="company"
                                aria-describedby="company" name="company" value="{{Auth::user()->company}}">
                            <div class="help-block with-errors company-error">
                                <span class="help-block"><strong>
                                        <p></p>
                                    </strong></span>
                            </div>
                        </div>
                        <div class="col-sm-12"><br>
                            <button type="button" class="btn primary-solid-btn" data-toggle="modal" data-target="#ChangePasswordModel">Update password</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn primary-solid-btn btn-circle btn-lg" type="button" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    <button class="btn btn-success btn-circle btn-lg" onclick="submitForm(this)" data-alert="alert"
                        type="button"><i class="fas fa-check"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="/logout">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- Change Password Modal -->
<div class="modal fade" id="ChangePasswordModel" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Change Password</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="{{ url('/user/update-password') }}" name="change-password-form" id="change-password-form-id" processData="false" ,
                contentType="false" class="form-password">
                <div class="modal-body">
                    <label class="control-label">Current password<sup class="mandatory">*</sup></label>
                    <input type="password" name="current-password" class="form-control" id="current-password">
                    <div class="help-block with-errors current-password-error">
                        <span class="help-block"><strong>
                                <p></p>
                            </strong></span>
                    </div>
                    <label class="control-label">New password<sup class="mandatory">*</sup></label>
                    <input type="password" name="new-password" class="form-control" id="new-password">
                    <div class="help-block with-errors new-password-error">
                        <span class="help-block"><strong>
                                <p></p>
                            </strong></span>
                    </div>
                    <label class="control-label">Confirm password<sup class="mandatory">*</sup></label>
                    <input type="password" name="confirm-password" class="form-control" id="confirm-password">
                    <div class="help-block with-errors confirm-password-error">
                        <span class="help-block"><strong>
                                <p></p>
                            </strong></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn primary-solid-btn btn-circle btn-lg" data-toggle="modal" data-target="#myprofile"><i class="fas fa-arrow-left"></i></button>
                    <button type="button" class="btn btn-success btn-circle btn-lg" onclick="submitForm(this)" data-alert="alert" ><i class="fas fa-check"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
