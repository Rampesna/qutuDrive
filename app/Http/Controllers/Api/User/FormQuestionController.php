<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\FormQuestionController\GetByFormIdWithAnswersRequest;
use App\Interfaces\Eloquent\IFormQuestionService;

class FormQuestionController extends Controller
{
    use HttpResponse;

    /**
     * @var $formQuestionService
     */
    private $formQuestionService;

    public function __construct(IFormQuestionService $formQuestionService)
    {
        $this->formQuestionService = $formQuestionService;
    }

    /**
     * @param GetByFormIdWithAnswersRequest $request
     */
    public function getByFormIdWithAnswers(GetByFormIdWithAnswersRequest $request)
    {
        $response = $this->formQuestionService->getByFormIdWithAnswers(
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
