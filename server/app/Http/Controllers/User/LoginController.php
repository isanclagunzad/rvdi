<?php

namespace App\Http\Controllers\User;

use App\Lib\Enumerations\UserStatus;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Model\Employee;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->intended(url('/dashboard'));
        }

        return view('admin.login');
    }

    public function Auth(LoginRequest $request)
    {
        if (auth()->attempt(['user_name' => $request->user_name, 'password' => $request->user_password])) {
            $userStatus = Auth::user()->status;

            $credentials = [
                'user_name' => $request->get('user_name'),
                'password' => $request->get('user_password')
            ];

            if ($userStatus == UserStatus::$ACTIVE) {
                $employee = Employee::where('user_id', auth()->user()->user_id)->first();
                $oldToken = auth()->guard('api')->tokenById(auth()->user()->user_id);
                // Remove old token
                if($oldToken != null) {
                    auth()->guard('api')->setToken($oldToken)->invalidate();
                }

                $user_data = [
                    "user_id"       => auth()->user()->user_id,
                    "user_name"     => auth()->user()->user_name,
                    "role_id"       => auth()->user()->role_id,
                    "employee_id"   => $employee->employee_id,
                    "email"         => $employee->email,
                    "bearer_token"  => auth()->guard('api')->attempt($credentials)
                ];

                session()->put('logged_session_data', $user_data);
                return redirect()->intended(url('/dashboard'));
            } elseif ($userStatus == UserStatus::$INACTIVE) {
                auth()->logout();
                return redirect(url('login'))
                    ->withInput()
                    ->with('error', 'You are temporary blocked. please contact to admin');
            } else {
                auth()->logout();
                return redirect(url('login'))
                    ->withInput()
                    ->with('error', 'You are terminated. please contact to admin');
            }
        } else {
            return redirect(url('login'))
                ->withInput()
                ->with('error', 'Unable to log in with provided credentials');
        }
    }



    public function logout()
    {
        auth()->logout();
        session()->flush();

        return redirect(url('login'))->with('success', 'Logged out');
    }
}
