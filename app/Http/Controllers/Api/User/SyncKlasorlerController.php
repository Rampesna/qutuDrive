<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\SyncklasorlerController\GetByCompanyIdRequest;
use App\Interfaces\Eloquent\ISyncKlasorlerService;

class SyncKlasorlerController extends Controller
{
    use HttpResponse;

    /**
     * @var $syncklasorler
     */
    private $syncklasorler;

    public function __construct(ISyncKlasorlerService $syncklasorlerService)
    {
        $this->syncklasorler = $syncklasorlerService;
    }

    /**
     * @param GetByCompanyIdRequest $request
     */
    public function getByCompanyId(GetByCompanyIdRequest $request)
    {
        $response = $this->syncklasorler->getByCompanyId(
            $request->companyId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
