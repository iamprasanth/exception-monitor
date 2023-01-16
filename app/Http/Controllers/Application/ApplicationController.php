<?php

namespace SMT\Http\Controllers\Application;

use SMT\Http\Controllers\Controller;
use SMT\Http\Requests\ApplicationRequest;
use SMT\Services\Application\ApplicationService;
use Illuminate\Http\Request;
use Session;
use Validator;
use Response;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApplicationService $applicationService)
    {
        $this->middleware('auth');
        $this->applicationService = $applicationService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('applications.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request)
    {
        $validator = Validator::make(
            $request->all(),
            []
        );
        $store = $this->applicationService->save($request);
        if (http_response_code() == 200) {
            return Response::json(['success' => '1']);
        } else if(http_response_code() == 402) {
            $validator->getMessageBag()->add('connect', 'Application base path is incorrect. Please check and retry');

            return Response::make([
                'errors' => $validator->errors(),
            ], 422);   
        } else {
            $validator->getMessageBag()->add('connect', 'Connection could not be established. Please check server details!');

            return Response::make([
                'errors' => $validator->errors(),
            ], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationRequest $request)
    {
        $validator = Validator::make(
            $request->all(),
            []
        );
        $update = $this->applicationService->save($request);
        if (http_response_code() == 200) {
            return Response::json(['success' => '1']);
        } else {
            $validator->getMessageBag()->add('connect', 'Connection could not be established. Please check server details!');

            return Response::make([
                'errors' => $validator->errors(),
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request   $request
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $delete = $this->applicationService->delete($id);
        if ($delete) {
            return Response::json(['success' => '1']);
        }
    }

    /**
     * View the application.
     * */
    public function view()
    {
        $response = $this->applicationService->view();
        if ($response) {
            $data = [
                'id' => $response['id'],
                "name" => $response['name'],
                "framework" => $response['framework'],
                "language" => $response['language'],
                "server_connect" => $response['server_connect'],
                "host" => $response['getServerDetails']['host'],
                "username" => $response['getServerDetails']['username'],
                "password" => $response['getServerDetails']['password'],
                "path" => $response['getServerDetails']['path'],
            ];

            Session::put('selected_project', $response['id']);

            return view('applications.view', ['data' => $data]);
        } else {
            return redirect('/dashboard');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request   $request
     * @return \Illuminate\Http\Response
     */
    public function changeApplication($id)
    {
        Session::put('selected_project', $id);

        return true;
    }
}
