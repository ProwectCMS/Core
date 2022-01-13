<?php

namespace ProwectCMS\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ProwectCMS\Core\Models\AccountCredential;

class AuthController extends Controller
{
    public function viewLogin()
    {
        return view('prowectcms::admin.page.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|filled',
            'password' => 'required|filled',

            'remember' => 'boolean'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
        $remember = $request->input('remember', false);

        $auth = Auth::guard('prowectcms');

        $credentials = [
            'type' => AccountCredential::TYPE_EMAIL,
            'username' => $username,
            'password' => $password
        ];

        if ($auth->attempt($credentials, $remember)) {
            return redirect()->intended(route('prowectcms.admin.dashboard'));
        }

        return redirect()->intended(route('prowectcms.admin.login'))->with('flash_error', 'Login failed!'); // TODO: localization
    }

    public function logout()
    {
        $auth = Auth::guard('prowectcms');

        $auth->logout();

        return redirect()->route('prowectcms.admin.login')->with('flash_success', 'You have successfully been logged out.'); // TODO: localization
    }
}