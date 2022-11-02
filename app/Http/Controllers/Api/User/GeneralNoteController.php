<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\GeneralNoteController\IndexRequest;
use App\Http\Requests\Api\User\GeneralNoteController\GetByIdRequest;
use App\Http\Requests\Api\User\GeneralNoteController\CreateRequest;
use App\Http\Requests\Api\User\GeneralNoteController\UpdateRequest;
use App\Http\Requests\Api\User\GeneralNoteController\DeleteRequest;
use App\Interfaces\Eloquent\IGeneralNoteService;

class GeneralNoteController extends Controller
{
    use HttpResponse;

    /**
     * @var $generalNoteService
     */
    private $generalNoteService;

    public function __construct(IGeneralNoteService $generalNoteService)
    {
        $this->generalNoteService = $generalNoteService;
    }

    /**
     * @param IndexRequest $request
     */
    public function index(IndexRequest $request)
    {
        $response = $this->generalNoteService->index(
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
        $response = $this->generalNoteService->getById(
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
        $response = $this->generalNoteService->create(
            $request->companyId,
            $request->title,
            $request->note
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
        $response = $this->generalNoteService->update(
            $request->id,
            $request->title,
            $request->note
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
        $response = $this->generalNoteService->delete(
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
