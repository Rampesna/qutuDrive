<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class UserGroupController extends Controller
{
    public function index()
    {
        return view('user.modules.userGroup.index.index');
    }
}
