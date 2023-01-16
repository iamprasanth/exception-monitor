<?php

namespace SMT\Http\Controllers\Auth;

use SMT\Http\Controllers\Controller;
use SMT\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use SMT\Models\Application;
use Response;
use Auth;
use Validator;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function checkLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        $validator = Validator::make(
            $credentials,
            [
                'email' => 'required|exists:users,email',
                'password' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        if (Auth::attempt($credentials, $request->remember)) {
            if(Auth::user()->is_active == 0) {
                Auth::logout();
                return response()->json(["error" => "Inactive user"], 401);
            }
            $appId = Application::where('owner_id', Auth::user()->id)->select('id')->first();
            $appId ? Session::put('selected_project', $appId['id']) : Session::forget('selected_project');

            return Response::json(['success' => '1']);

        }
        return response()->json(["error" => "Password invalid"], 401);
    }

    protected function credentials($request)
    {
        $credentials = [
            'email' => strtolower($request->email),
            'password' => $request->password
        ];

        return $credentials;
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
