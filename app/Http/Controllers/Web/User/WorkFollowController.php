<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class WorkFollowController extends Controller
{
    public function index()
    {
        return view('user.modules.workFollow.index.index');
    }

    public function overview()
    {
        return view('user.modules.workFollow.overview.index', [
            'id' => request()->route('id')
        ]);
    }

    public function board()
    {
        return view('user.modules.workFollow.board.index', [
            'id' => request()->route('id')
        ]);
    }
}
