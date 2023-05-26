<?php

namespace App\Http\Controllers\Api\User\ApiAyssoft;

use App\Core\Controller;
use App\Http\Requests\Api\User\ApiAyssoft\BalanceInquiryController\IndexRequest;
use App\Http\Requests\Api\User\BoardController\CreateRequest;
use App\Http\Requests\Api\User\BoardController\UpdateNameRequest;
use App\Http\Requests\Api\User\BoardController\UpdateOrderRequest;
use App\Http\Requests\Api\User\BoardController\DeleteRequest;
use App\Interfaces\ApiAyssoft\IBalanceInquiryService;
use App\Interfaces\Eloquent\IBoardService;
use App\Core\HttpResponse;
use App\Interfaces\Eloquent\IFirmalarService;

class BalanceInquiryController extends Controller
{
    use HttpResponse;

    /**
     * @var $balanceInquiryService
     */
    private $balanceInquiryService;

    /**
     * @param IBalanceInquiryService $balanceInquiryService
     */
    public function __construct(IBalanceInquiryService $balanceInquiryService)
    {
        $this->balanceInquiryService = $balanceInquiryService;
    }

    /*
     * IndexRequest $request
     * */
    public function Index(IndexRequest $request, IFirmalarService $firmalarService)
    {
        $companyResponse = $firmalarService->getById($request->companyId);
        if ($companyResponse->isSuccess()) {
            $response = $this->balanceInquiryService->Index(
                $companyResponse->getData()->VKNTCKN,
                'eYedekleme'
            );

            return $this->httpResponse(
                $response->getMessage(),
                $response->getStatusCode(),
                $response->getData(),
                $response->isSuccess()
            );
        } else {
            return $this->httpResponse(
                $companyResponse->getMessage(),
                $companyResponse->getStatusCode(),
                $companyResponse->getData(),
                $companyResponse->isSuccess()
            );
        }
    }
}
