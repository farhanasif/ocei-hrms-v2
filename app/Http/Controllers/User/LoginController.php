<?php

namespace App\Http\Controllers\User;

use App\Lib\Enumerations\UserStatus;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\LoginRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Model\Employee;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Session;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{


    public function index()
    {
        if (Auth::check()) {
            return redirect()->intended(url('/dashboard'));
        }

        return view('admin.login');
    }



    public function Auth(LoginRequest $request)
    {
        if (Auth::attempt(['user_name' => $request->user_name, 'password' => $request->user_password])) {
            $userStatus = Auth::user()->status;
            if ($userStatus == UserStatus::$ACTIVE) {
                $employee = Employee::where('user_id', Auth::user()->user_id)->first();
                $user_data = [
                    "user_id"       => Auth::user()->user_id,
                    "user_name"     => Auth::user()->user_name,
                    "role_id"       => Auth::user()->role_id,
                    "employee_id"   => $employee->employee_id,
                    "email"         => $employee->email,
                ];
                session()->put('logged_session_data', $user_data);
                return redirect()->intended(url('/dashboard'));
            } elseif ($userStatus == UserStatus::$INACTIVE) {
                Auth::logout();
                return redirect(url('login'))->withInput()->with('error', 'You are temporary blocked. please contact to admin');
            } else {
                Auth::logout();
                return redirect(url('login'))->withInput()->with('error', 'You are terminated. please contact to admin');
            }
        } else {
            return redirect(url('login'))->withInput()->with('error', 'User name or password does not matched');
        }
    }



    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect(url('login'))->with('success', 'logout successful ..!');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        // dd($request->all());

        $this->validate($request, [
            'email' => 'required|email|exists:employee',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('emails.forgetPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($token)
    {
        // dd($token);
        return view('admin.showResetPasswordForm', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        // dd($request->all());

        $this->validate($request, [
            'email' => 'required|email|exists:employee',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $employeeCheckEmail = DB::table('employee')->where('email', $request->email)->first();
        // dd($employeeCheckEmail);
        if ($employeeCheckEmail) {
            $user = User::where('user_id', $employeeCheckEmail->user_id)
                ->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')->where(['email' => $request->email])->delete();
            return redirect('/login')->with('success', 'Your password has been changed!');
        } else {
            return back()->withInput()->with('error', 'Your Email Not Found!');
        }
    }
}
