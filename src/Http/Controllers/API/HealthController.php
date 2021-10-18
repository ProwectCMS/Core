<?php

namespace ProwectCMS\Core\Http\Controllers\API;

class HealthController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'ok',
            'key' => 'health.ok'
        ]);
    }
}