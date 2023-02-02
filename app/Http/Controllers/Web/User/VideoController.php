<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        return view('user.modules.video.index.index');
    }


    public function videoList(){
        return view('user.modules.video.videolist.index');
    }
}
