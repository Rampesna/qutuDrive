<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\CompanyController\GetAllRequest;
use App\Interfaces\Eloquent\IFirmalarService;
use App\Core\HttpResponse;

class CompanyController extends Controller
{
    use HttpResponse;

    /**
     * @var $firmalarService
     */
    private $firmalarService;

    /**
     * @var IFirmalarService $firmalarService
     */
    public function __construct(IFirmalarService $firmalarService)
    {
        $this->firmalarService = $firmalarService;
    }

    /**
     * @param GetAllRequest $request
     */
    public function getAll(GetAllRequest $request)
    {
        $response = $this->firmalarService->getAll();

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
