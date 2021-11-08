<?php

namespace ProwectCMS\Core\Http\Controllers\Admin;

class AuthController extends Controller
{
    public function viewLogin()
    {
        return view('prowectcms::admin.page.auth.login');
    }
}