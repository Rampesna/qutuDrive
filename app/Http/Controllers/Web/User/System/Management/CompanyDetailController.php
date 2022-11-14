<?php

namespace App\Http\Controllers\Web\User\System\Management;

use App\Core\Controller;
use Illuminate\Http\Request;

class CompanyDetailController extends Controller
{
    public function index(Request $request)
    {
        return view('user.modules.system.management.company.detail.index.index', [
            'id' => $request->id
        ]);
    }

    public function package(Request $request)
    {
        return view('user.modules.system.management.company.detail.package.index', [
            'id' => $request->id
        ]);
    }

    public function backupStatus(Request $request)
    {
        return view('user.modules.system.management.company.detail.backupStatus.index', [
            'id' => $request->id
        ]);
    }

    public function eLedgerBackupStatus(Request $request)
    {
        return view('user.modules.system.management.company.detail.eLedgerBackupStatus.index', [
            'id' => $request->id
        ]);
    }

    public function user(Request $request)
    {
        return view('user.modules.system.management.company.detail.user.index', [
            'id' => $request->id
        ]);
    }
}
