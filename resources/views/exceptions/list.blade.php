@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Exceptions</h6>
              </div>
              <div class="card-body">
                  <ul class="spt-button-list d-flex list-unstyled m-0 align-items-end mb-3">
                      <li class="mr-2">
                          <div class="input-group-date">
                              <label class="control-label">From</label>
                              <input id="from_date" class="datepicker form-control" readonly="true" type="text"
                                  class="form-control spt-datepicker" value="">
                          </div>
                      </li>
                      <li class="mr-2">
                          <div class="input-group-date">
                              <label class="control-label">To</label>
                              <input id="to_date" class="datepicker form-control" readonly="true" type="text"
                                  class="form-control spt-datepicker" value="">
                          </div>
                      </li>
                  </ul>
                <div class="table-responsive">
                  <table class="table table-bordered" id="smt-exception-table" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Environment</th>
                        <th>Type</th>
                        <th>Message</th>
                        <th></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
        </div>
        <div id="viewException" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <textarea class="form-control" id="view_details" rows="15"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script type="text/javascript" src="{{asset("js/exception.js")}}"></script>
@endsection
@endsection
