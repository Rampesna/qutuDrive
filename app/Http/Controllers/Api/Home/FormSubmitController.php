<?php

namespace App\Http\Controllers\Api\Home;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\Home\FormSubmitController\SubmitRequest;
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
     * @param SubmitRequest $request
     */
    public function submit(SubmitRequest $request)
    {
        $response = $this->formSubmitService->submit(
            $request->formId,
            $request->questionAnswers
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
