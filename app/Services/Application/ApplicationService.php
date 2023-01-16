<?php
namespace SMT\Services\Application;

use Carbon\Carbon;
use SMT\Models\Application;
use SMT\Models\ServerDetail;
use Illuminate\Support\Facades\DB;
use Auth;
use SSH;
use Config;
use Session;

class ApplicationService
{
    /**
     * Edit an Application
     */
    public function view()
    {
        $projectId = Session::has('selected_project') ? Session::get('selected_project') : 0;

        return Application::select(
            'id',
            'name',
            'language',
            'framework',
            'is_active',
            'server_connect'
        )->with(
            [
                'getServerDetails'
                ]
        )->where(
            'id',
            $projectId
        )->where(
            'is_deleted',
            0
        )->first();
    }

    /**
     * Add / Update an Application
     */
    public function save($request)
    {
        DB::beginTransaction();
        try {
            $this->checkConnection($request);
            $user = Auth::user();
            $application = [
                'owner_id' => $user->id,
                'slug' => str_slug($request['name'], '-'),
                'name' => $request['name'],
                'language' => $request['language'],
                'framework' => $request['framework'],
                'server_connect' => 1
            ];
            if (isset($request['id'])) {
                $application =  Application::where('id', $request['id'])->update($application);
                if ($application) {
                    if (substr($request['path'], -1) != '/') {
                        $request['path'] .= "/";
                    }
                    $serverDetails = [
                        'host' => $request['host'],
                        'username' => $request['username'],
                        'password' => $request['password'],
                        'path' => $request['path']
                    ];
                    ServerDetail::where('application_id', $request['id'])->update($serverDetails);
                }
            } else {
                $applicationId = Application::insertGetId($application);
                if ($applicationId) {
                    if (substr($request['path'], -1) != '/') {
                        $request['path'] .= "/";
                    }
                    $serverDetails = [
                        'application_id' => $applicationId,
                        'host' => $request['host'],
                        'username' => $request['username'],
                        'password' => $request['password'],
                        'path' => $request['path']
                    ];
                    $server = ServerDetail::insertGetId($serverDetails);
                }
                if ($server) {
                    Session::put('selected_project', $applicationId);
                    \Artisan::call('check:exception --application='.$applicationId.'');
                    $appConnect = Application::where('id', $applicationId)->first();
                    if($appConnect['server_connect'] == 0) {
                        http_response_code(402);
                        DB::rollback();
                    }
                }
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            http_response_code(500);
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        return true;
    }

    /**
     * Delete an Application
     */
    public function delete($id)
    {
        return Application::where('id', $id)
            ->update([
                'is_deleted' => 1
            ]);
    }

    /**
     * Check SSH connection
     */
    public function checkConnection($request)
    {
        Config::set('remote.connections.runtime.host', $request['host']);
        Config::set('remote.connections.runtime.username', $request['username']);
        Config::set('remote.connections.runtime.password', $request['password']);

        return SSH::into('runtime')->run([]);
    }
}
