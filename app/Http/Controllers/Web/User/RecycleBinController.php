<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class RecycleBinController extends Controller
{
    public function index()
    {
        return view('user.modules.recycleBin.index.index');
    }
}
