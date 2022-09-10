<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class FormController extends Controller
{
    public function index()
    {
        return view('user.modules.form.index.index');
    }
}
