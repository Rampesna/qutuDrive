<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\FormController\GetByCompanyIdRequest;
use App\Http\Requests\Api\User\FormController\GetByIdRequest;
use App\Http\Requests\Api\User\FormController\CreateRequest;
use App\Http\Requests\Api\User\FormController\UpdateRequest;
use App\Http\Requests\Api\User\FormController\UpdateAccessibleRequest;
use App\Http\Requests\Api\User\FormController\CreateFormQuestionsRequest;
use App\Http\Requests\Api\User\FormController\DeleteRequest;
use App\Http\Requests\Api\User\FormController\GetShareLinkRequest;
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
     * @param GetByCompanyIdRequest $request
     */
    public function getByCompanyId(GetByCompanyIdRequest $request)
    {
        $response = $this->formService->getByCompanyId(
            $request->companyId,
            $request->pageIndex,
            $request->pageSize,
            $request->keyword
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
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

    /**
     * @param CreateRequest $request
     */
    public function create(CreateRequest $request)
    {
        $response = $this->formService->create(
            $request->companyId,
            $request->name,
            $request->title,
            $request->description
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param UpdateRequest $request
     */
    public function update(UpdateRequest $request)
    {
        $response = $this->formService->update(
            $request->id,
            $request->name,
            $request->title,
            $request->description
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param UpdateAccessibleRequest $request
     */
    public function updateAccessible(UpdateAccessibleRequest $request)
    {
        $response = $this->formService->updateAccessible(
            $request->id,
            $request->accessible
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param CreateFormQuestionsRequest $request
     */
    public function createFormQuestions(CreateFormQuestionsRequest $request)
    {
        $response = $this->formService->createFormQuestions(
            $request->formId,
            $request->formQuestions
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param DeleteRequest $request
     */
    public function delete(DeleteRequest $request)
    {
        $response = $this->formService->delete(
            $request->id
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetShareLinkRequest $request
     */
    public function getShareLink(GetShareLinkRequest $request)
    {
        $response = $this->formService->getShareLink(
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
