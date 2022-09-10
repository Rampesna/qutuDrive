<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class SharedDirectoryController extends Controller
{
    public function index()
    {
        return view('user.modules.sharedDirectory.index.index');
    }
}
