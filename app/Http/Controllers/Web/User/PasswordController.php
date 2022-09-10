<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class PasswordController extends Controller
{
    public function index()
    {
        return view('user.modules.password.index.index');
    }
}
