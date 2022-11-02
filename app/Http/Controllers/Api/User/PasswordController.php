<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\PasswordController\IndexRequest;
use App\Http\Requests\Api\User\PasswordController\GetByIdRequest;
use App\Http\Requests\Api\User\PasswordController\CreateRequest;
use App\Http\Requests\Api\User\PasswordController\UpdateRequest;
use App\Http\Requests\Api\User\PasswordController\DeleteRequest;
use App\Interfaces\Eloquent\IPasswordService;

class PasswordController extends Controller
{
    use HttpResponse;

    /**
     * @var $passwordService
     */
    private $passwordService;

    public function __construct(IPasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    /**
     * @param IndexRequest $request
     */
    public function index(IndexRequest $request)
    {
        $response = $this->passwordService->index(
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
        $response = $this->passwordService->getById(
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
        $response = $this->passwordService->create(
            $request->companyId,
            $request->name,
            $request->link,
            $request->username,
            $request->password,
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
        $response = $this->passwordService->update(
            $request->id,
            $request->name,
            $request->link,
            $request->username,
            $request->password,
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
     * @param DeleteRequest $request
     */
    public function delete(DeleteRequest $request)
    {
        $response = $this->passwordService->delete(
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
