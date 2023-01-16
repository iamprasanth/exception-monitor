<?php

namespace SMT\Http\Controllers\User;

use SMT\Http\Controllers\Controller;
use SMT\Services\User\UserService;
use Illuminate\Http\Request;
use Response;
use Validator;
use Auth;
use Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    /**
     * Update the user. 
     *
     *  @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required',
                'company' => 'required',
            ]
        );
        if ($validator->fails()) {
            return Response::make([
                'errors' => $validator->errors(),
            ], 422);
        }
        $update = $this->userService->update($request);
        if ($update) {
            return Response::json(['success' => '1']);
        }
    }

    /**
     * Update the user password. 
     *
     *  @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'current-password' => 'required',
                'new-password' => 'required|min:6|same:confirm-password',
                'confirm-password' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $password = \Auth::user()->password;
        if (!Hash::check($request['current-password'], $password)) {
            $validator->errors()->add('current-password', 'Password entered is incorrect');

            return Response::make([
                'errors' => $validator->errors(),
            ], 422);
        }
        $reset =  $this->userService->updatePassword($request);
        if ($reset) {
            return Response::json(['success' => '1']);
        }
    }
}
