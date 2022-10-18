<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class ELedgerSecondBackupController extends Controller
{
    public function index()
    {
        return view('user.modules.eLedgerSecondBackup.index.index');
    }
}
