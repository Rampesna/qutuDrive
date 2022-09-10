<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class SharedWithMeController extends Controller
{
    public function index()
    {
        return view('user.modules.sharedWithMe.index.index');
    }
}
