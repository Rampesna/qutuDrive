<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        return view('user.modules.form.index.index');
    }

    public function update(Request $request)
    {
        if (!$request->id) {
            abort(404);
        }

        return view('user.modules.form.update.index', [
            'id' => $request->id
        ]);
    }
}
