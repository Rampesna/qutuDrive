<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class SyncklasorController extends Controller
{
    public function index()
    {
        return view('user.modules.syncklasor.index.index');
    }
}
