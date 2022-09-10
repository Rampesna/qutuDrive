<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class WorkFollowController extends Controller
{
    public function index()
    {
        return view('user.modules.workFollow.index.index');
    }
}
