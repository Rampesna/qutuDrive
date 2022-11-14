<?php

namespace App\Http\Controllers\Web\User\System\Management;

use App\Core\Controller;

class PackageConnectionController extends Controller
{
    public function index()
    {
        return view('user.modules.system.management.packageConnection.index.index');
    }
}
