<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\FormSubmitController\GetByFormIdRequest;
use App\Interfaces\Eloquent\IFormSubmitService;

class FormSubmitController extends Controller
{
    use HttpResponse;

    /**
     * @var $formSubmitService
     */
    private $formSubmitService;

    public function __construct(IFormSubmitService $formSubmitService)
    {
        $this->formSubmitService = $formSubmitService;
    }

    /**
     * @param GetByFormIdRequest $request
     */
    public function getByFormId(GetByFormIdRequest $request)
    {
        $response = $this->formSubmitService->getByFormId(
            $request->formId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
