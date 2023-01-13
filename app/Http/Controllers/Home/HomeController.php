<?php

namespace App\Http\Controllers\Home;

use App\Core\Controller;
use App\Models\Eloquent\Firmalar;
use App\Models\Eloquent\Kullanicilar;
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
        $user = Kullanicilar::with([
            'permissions',
        ])->find(5692);

        return $user;
    }
}
