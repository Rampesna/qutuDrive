<?php

namespace App\Http\Controllers\Home;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->guard('user_web')->check()) {
            return redirect()->route('user.web.dashboard.index');
        }

        return redirect()->route('user.web.authentication.login.index');
    }
}
