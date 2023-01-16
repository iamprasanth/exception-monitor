@extends('layouts.app')
@section('content')
<div class="container-fluid p-3">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Dashboard</h6>
      </div>
      <div class="card-body">
          <ul class="d-flex list-unstyled m-0 align-items-end mb-3">
              <li class="mr-2">
                  <label class="control-label">From date</label>
                  <input id="from_date" class="datepicker form-control" readonly="true" onchange="getReports()" type="text">
              </li>
              <li class="mr-2">
                  <label class="control-label">To date</label>
                  <input id="to_date" class="datepicker form-control" readonly="true" onchange="getReports()" type="text">
              </li>
          </ul>
          <div id="myChart">
               <canvas id="canvas_chart" width="400" height="150"></canvas>
          </div>
      </div>
    </div>
</div>

@section('scripts')
<script type="text/javascript" src="{{asset("js/dashboard.js")}}"></script>
@endsection
@endsection
