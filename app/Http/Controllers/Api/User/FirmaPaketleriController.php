<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\FirmaPaketleriController\GetByCompanyIdRequest;
use App\Interfaces\Eloquent\IFirmaPaketleriService;

class FirmaPaketleriController extends Controller
{
    use HttpResponse;

    /**
     * @var $firmaPaketleriService
     */
    private $firmaPaketleriService;

    public function __construct(IFirmaPaketleriService $firmaPaketleriService)
    {
        $this->firmaPaketleriService = $firmaPaketleriService;
    }

    /**
     * @param GetByCompanyIdRequest $request
     */
    public function getByCompanyId(GetByCompanyIdRequest $request)
    {
        $response = $this->firmaPaketleriService->getByCompanyId(
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
