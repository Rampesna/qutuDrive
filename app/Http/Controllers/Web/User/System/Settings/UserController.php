<?php

namespace App\Http\Controllers\Web\User\System\Settings;

use App\Core\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('user.modules.system.settings.user.index.index');
    }
}
