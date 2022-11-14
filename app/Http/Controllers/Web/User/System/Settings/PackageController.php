<?php

namespace App\Http\Controllers\Web\User\System\Settings;

use App\Core\Controller;

class PackageController extends Controller
{
    public function index()
    {
        return view('user.modules.system.settings.package.index.index');
    }
}
