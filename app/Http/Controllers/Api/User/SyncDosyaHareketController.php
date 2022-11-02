<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\SyncDosyaHareketController\GetBySunucuKlasorIdRequest;
use App\Interfaces\Eloquent\ISyncDosyaHareketService;

class SyncDosyaHareketController extends Controller
{
    use HttpResponse;

    /**
     * @var $syncdosyahareketService
     */
    private $syncdosyahareketService;

    public function __construct(ISyncDosyaHareketService $syncdosyahareketService)
    {
        $this->syncdosyahareketService = $syncdosyahareketService;
    }

    /**
     * @param GetBySunucuKlasorIdRequest $request
     */
    public function getBySunucuKlasorId(GetBySunucuKlasorIdRequest $request)
    {
        $response = $this->syncdosyahareketService->getBySunucuKlasorId(
            $request->sunucuKlasorId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
