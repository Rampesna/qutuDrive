<?php

namespace App\Http\Controllers\Web\User\System\Management;

use App\Core\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        return view('user.modules.system.management.company.index.index');
    }
}
