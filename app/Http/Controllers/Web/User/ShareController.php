<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class ShareController extends Controller
{
    public function index()
    {
        return view('user.modules.share.index.index');
    }
}
