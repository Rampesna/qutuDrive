<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class HistoryController extends Controller
{
    public function index()
    {
        return view('user.modules.history.index.index');
    }
}
