<?php

namespace App\Http\Controllers\Web\User\System\Management;

use App\Core\Controller;

class GibELedgerController extends Controller
{
    public function index()
    {
        return view('user.modules.system.management.gibELedger.index.index');
    }
}
