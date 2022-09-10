<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class QutuMailController extends Controller
{
    public function index()
    {
        return view('user.modules.qutuMail.index.index');
    }
}
