<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\GibSaklamaOzelListeController\GetAllRequest;
use App\Http\Requests\Api\User\GibSaklamaOzelListeController\CreateRequest;
use App\Interfaces\Eloquent\IGibSaklamaOzelListeService;

class GibSaklamaOzelListeController extends Controller
{
    use HttpResponse;

    /**
     * @var $gibSaklamaOzelListeService
     */
    private $gibSaklamaOzelListeService;

    public function __construct(IGibSaklamaOzelListeService $gibSaklamaOzelListeService)
    {
        $this->gibSaklamaOzelListeService = $gibSaklamaOzelListeService;
    }

    /**
     * @param GetAllRequest $request
     */
    public function getAll(GetAllRequest $request)
    {
        $response = $this->gibSaklamaOzelListeService->getAll();

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param CreateRequest $request
     */
    public function create(CreateRequest $request)
    {
        $response = $this->gibSaklamaOzelListeService->create(
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
