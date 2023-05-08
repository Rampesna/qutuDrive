<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        return view('user.modules.document.index.index');
    }


    public function documentList(){
        return view('user.modules.document.documentList.index');
    }
}
