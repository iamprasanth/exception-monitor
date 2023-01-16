<?php

namespace SMT\Http\Controllers\Dashboard;

use SMT\Http\Controllers\Controller;
use SMT\Services\Dashboard\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DashboardService $dashboardService)
    {
        $this->middleware('auth');
        $this->dashboardService = $dashboardService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = getApplications();
        if ($apps->count() > 0) {
            return view('dashboard.view');
        } else {
            return view('applications.new');
        }
    }

    /**
     * Get reports of logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReports(Request $request)
    {
        $data = $this->dashboardService->getReports($request);

        return $data;
    }
}
