<?php

namespace ProwectCMS\Core\Http\Controllers\Admin;

class DashboardController extends Controller
{
    public function index()
    {
        return view('prowectcms::admin.page.dashboard.index');
    }
}