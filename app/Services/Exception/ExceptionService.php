<?php
namespace SMT\Services\Exception;

use Carbon\Carbon;
use SMT\Models\Application;
use SMT\Models\ServerDetail;
use SMT\Models\Exception;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;

class ExceptionService
{
    protected $config = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getExceptions($request)
    {
        $projectId = Session::has('selected_project') ? Session::get('selected_project') : 0;

        $data = Exception::where('project_id', $projectId)
                        ->select('id', 'project_id', 'date', 'timestamp', 'env', 'type', 'message', 'detail');
        $from = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : date('Y-m-d', strtotime('-7 day'));
        $to = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : date('Y-m-d');
        if ($request->from_date && $request->to_date) {
            $data = $data->whereBetween('date', [$from, $to])->get();
        } else {
            $data = $data->get();
        }
        updateUserVisit($menu = 'exceptions');


        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewException($id)
    {
        return Exception::where('id', $id)->select('id', 'project_id', 'date', 'timestamp', 'env', 'type', 'message', 'detail')->first();
    }

    /**
    *
    * For getting logs from the file for specified date
    *
    * @return $data array
    */
    public function filterLogs($request)
    {
        $from = date('Y-m-d', strtotime($request->from_date));
        $to = date('Y-m-d', strtotime($request->to_date));

        return Exception::whereBetween('date', [$from, $to])->get();
    }
}
