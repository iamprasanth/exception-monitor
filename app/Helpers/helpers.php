<?php

use Illuminate\Support\Facades\Request;
use SMT\Models\Application;
use Carbon\Carbon;

// Function for detecting active routes
function areActiveRoutes(array $routes, $output = "active")
{
    $action = Request::route()->getName();
    if (isset($routes)) {
        foreach ($routes as $route) {
            if ($action == $route) {
                return $output;
            }
        }
    }
}

// Function for getting all applications of current user
function getApplications()
{
    return DB::table('applications')
            ->select('owner_id','name','id','slug')
            ->where([
                ['is_deleted', 0],
                ['owner_id', Auth::user()->id]
            ])->get();
}

// Function for getting app slug
function getAppConnection()
{
    $id = Session::has('selected_project') ? Session::get('selected_project'): 0;

    return Application::where('id', $id)->value('server_connect');
}

// Funtion to store latest time of visiting a menu against a user
function updateUserVisit($menu)
{
    $update = DB::table('user_visits')
                ->where([
                    ['user_id', Auth::user()->id],
                    ['menu', $menu]
                ])->update([
                    'last_visit' => Carbon::now()
                ]);
    if (!$update) {
        return DB::table('user_visits')
            ->insert([
                'user_id' => Auth::user()->id,
                'menu' => $menu,
                'last_visit' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
    }

    return $update;
}

// Get count of new exception entries
function getNewExceptionsCount()
{
    $lastVisit = DB::table('user_visits')
                    ->where([
                        ['user_id', Auth::user()->id],
                        ['menu', 'exceptions']
                    ])->value('last_visit');
    if ($lastVisit) {
        return DB::table('exceptions')
                ->where([
                    ['project_id', session('selected_project')],
                    ['created_at', '>', $lastVisit]
                ])->count();
    }
}
