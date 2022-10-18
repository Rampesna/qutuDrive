<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;

class ELedgerBackupController extends Controller
{
    public function index()
    {
        return view('user.modules.eLedgerBackup.index.index');
    }
}
