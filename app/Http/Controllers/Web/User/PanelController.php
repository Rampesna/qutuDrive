<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class PanelController extends Controller
{
    public function index()
    {
        return view('user.modules.panel.index.index');
    }
}
