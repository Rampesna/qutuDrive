<?php

namespace App\Http\Controllers\Home;

use App\Core\Controller;
use App\Models\Eloquent\Firmalar;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->guard('user_web')->check()) {
            return redirect()->route('user.web.dashboard.index');
        }

        return redirect()->route('user.web.authentication.login.index');
    }

    public function deneme()
    {
        $company = Firmalar::find(13493)->users;

        return $company;
    }
}
