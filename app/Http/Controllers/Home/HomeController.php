<?php

namespace App\Http\Controllers\Home;

use App\Core\Controller;
use App\Models\Eloquent\Firmalar;
use App\Models\Eloquent\Kullanicilar;
use App\Services\ApiAyssoft\BalanceInquiryService;
use Illuminate\Support\Facades\Crypt;
use App\Core\HttpResponse;

class HomeController extends Controller
{
    use HttpResponse;
    public function index()
    {
        if (auth()->guard('user_web')->check()) {
            return redirect()->route('user.web.dashboard.index');
        }

        return redirect()->route('user.web.authentication.login.index');
    }

    public function deneme()
    {
        $balanceService = new BalanceInquiryService();
        $response = $balanceService->Index('3340561887', 'eYedekleme');
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function deneme2()
    {
        return auth()->user()->permissions()->get();
    }
}
