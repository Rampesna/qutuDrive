<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    use HttpResponse;

    public function changeLanguage(Request $request)
    {
        $locale = $request->get('locale');
        if (!in_array($locale, getLocaleList())) {
            return $this->httpResponse(
                __('languageController.changeLanguage.errorMessages.notInArray'),
                400
            );
        } else {
            Session::put('locale', $locale);
            $newLocale = Session::get('locale');
            App::setLocale($newLocale);
            return $this->httpResponse(
                __('languageController.changeLanguage.successMessages.success'),
                200,
                $newLocale
            );
        }
    }
}
