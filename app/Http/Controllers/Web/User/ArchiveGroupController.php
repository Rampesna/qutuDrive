<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class ArchiveGroupController extends Controller
{
    public function index()
    {
        return view('user.modules.archiveGroup.index.index');
    }
}
