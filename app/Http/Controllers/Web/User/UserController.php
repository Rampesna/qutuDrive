<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('user.modules.user.index.index');
    }
}
