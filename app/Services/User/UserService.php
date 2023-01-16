<?php
namespace SMT\Services\User;

use Carbon\Carbon;
use SMT\Models\User;
use Auth;

class UserService
{
    /**
     * Function to update user info
     */
    public function update($request)
    {
        return User::where('id', Auth::user()->id)
                ->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'company' => $request['company'],
                ]);
    }

    /**
     * Function to update user password
     */
    public function updatePassword($request)
    {
        return User::where('id', Auth::user()->id)
                ->update([
                    'password' => bcrypt($request['new-password'])
                ]);
    }
}
