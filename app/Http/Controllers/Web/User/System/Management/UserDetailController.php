<?php

namespace App\Http\Controllers\Web\User\System\Management;

use App\Core\Controller;
use Illuminate\Http\Request;

class UserDetailController extends Controller
{
    public function index(Request $request)
    {
        return view('user.modules.system.management.user.detail.index.index', [
            'id' => $request->id
        ]);
    }

    public function company(Request $request)
    {
        return view('user.modules.system.management.user.detail.company.index', [
            'id' => $request->id
        ]);
    }
}
