<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('user.modules.dashboard.index.index');
    }
}
