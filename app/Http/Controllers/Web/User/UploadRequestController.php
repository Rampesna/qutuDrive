<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class UploadRequestController extends Controller
{
    public function index()
    {
        return view('user.modules.uploadRequest.index.index');
    }
}
