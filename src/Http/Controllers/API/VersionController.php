<?php

namespace ProwectCMS\Core\Http\Controllers\API;

use Composer\InstalledVersions;

class VersionController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'ok',
            
            'packages' => [
                'core' => InstalledVersions::getVersion('prowectcms/core')
            ]
        ]);
    }
}