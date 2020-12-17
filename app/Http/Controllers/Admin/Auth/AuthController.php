<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('guest:admin', ['except' => 'getLogout' ]);
    }

    public function getLogin() {
        return view('admin.pages.auth.login');
    }

    public function postLogin(Request $r) {
        // 1- Validator::make()
        // 2- check if fails
        // 3- fails redirect or success not redirect

        $return = [
            'response' => 'success',
            'message' => 'تم تسجيل الدخول بنجاح',
            'url' => redirect()->intended('/admin')
        ];

        // grapping admin credentials
        $name = $r->input('email');
        $password = $r->input('password');
        // Searching for the admin matches the passed email or adminname
        $admin = Admin::where(function ($q) use ($name){
            $q->where('username', $name)->orWhere('email', $name);
        })->first();

        if ($admin && Hash::check($password, $admin->password)) {
            // login the admin
            Auth::guard('admin')->login($admin, $r->has('remember'));
        } else {
            $return = [
                'response' => 'error',
                'message' => 'البيانات المستخدمه خاطئه'
            ];
        }
        return response()->json($return);
    }

    /**
     * Logout The user
     */
    public function getLogout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
