<?php

namespace App\Http\Controllers\Web\User\System\Management;

use App\Core\Controller;

class PackageController extends Controller
{
    public function index()
    {
        return view('user.modules.system.management.package.index.index');
    }
}
