<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;
use App\Core\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    use Response;

    public function changeLanguage(Request $request)
    {
        $locale = $request->get('locale');
        if (!in_array($locale, getLocaleList())) {
            return $this->error(
                __('languageController.changeLanguage.errorMessages.notInArray'),
                400
            );
        } else {
            Session::put('locale', $locale);
            $newLocale = Session::get('locale');
            App::setLocale($newLocale);
            return $this->success(
                __('languageController.changeLanguage.successMessages.success'),
                $newLocale
            );
        }
    }
}
