<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class DocumentController extends Controller
{
    public function index()
    {
        return view('user.modules.document.index.index');
    }
}
