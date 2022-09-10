<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class CalendarController extends Controller
{
    public function index()
    {
        return view('user.modules.calendar.index.index');
    }
}
