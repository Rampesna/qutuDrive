<?php

namespace App\Http\Controllers\Home;

use App\Core\Controller;
use App\Models\Eloquent\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class FormController extends Controller
{
    public function form(Request $request)
    {
        if (!$request->id) {
            abort(404);
        }

        try {
            $id = Crypt::decrypt($request->id);
            $form = Form::find($id);
            if (!$form || $form->accessible == 0) {
                abort(404);
            }
            return view('home.modules.form.index.index', [
                'id' => $id
            ]);
        } catch (\Exception $exception) {
            abort(404);
        }
    }
}
