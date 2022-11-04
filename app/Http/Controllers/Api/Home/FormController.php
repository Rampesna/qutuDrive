<?php

namespace App\Http\Controllers\Api\Home;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\Home\FormController\GetByIdRequest;
use App\Interfaces\Eloquent\IFormService;

class FormController extends Controller
{
    use HttpResponse;

    /**
     * @var $formService
     */
    private $formService;

    public function __construct(IFormService $formService)
    {
        $this->formService = $formService;
    }

    /**
     * @param GetByIdRequest $request
     */
    public function getById(GetByIdRequest $request)
    {
        $response = $this->formService->getById(
            $request->id
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
