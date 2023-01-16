<?php
namespace SMT\Services\Dashboard;

use Carbon\Carbon;
use SMT\Models\Application;
use SMT\Models\ServerDetail;
use SMT\Models\Exception;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class DashboardService
{
    /**
     * Display a listing of the logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReports($request)
    {
        $arrLabels = [];
        $arrDatasets = [];
        $from = date('Y-m-d', strtotime($request['from_date']));
        $to = date('Y-m-d', strtotime($request['to_date']));

        $projectId = Session::get('selected_project');
        $logReports = Exception::where('project_id', $projectId)
            ->select(DB::raw('count(id) as error_count, date'))
            ->groupBy('date')
            ->orderBy('date','asc');
        if ($request['from_date'] && $request['to_date']) {
            $logReports = $logReports->whereBetween('date', [$from, $to])->get()->toArray();
        } else {
            $logReports = $logReports->get()->toArray();
        }

        if($logReports) {
            foreach($logReports as $key => $value) {
                $arrLabels[] = $value['date'];
                $arrDatasets[] = $value['error_count'];
            }
        }

        $arrReturn = ['labels' => $arrLabels, 'datasets' => $arrDatasets];
        return $arrReturn;
    }

}
