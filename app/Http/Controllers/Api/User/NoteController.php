<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\NoteController\GetByDateBetweenRequest;
use App\Http\Requests\Api\User\NoteController\GetByIdRequest;
use App\Http\Requests\Api\User\NoteController\CreateRequest;
use App\Http\Requests\Api\User\NoteController\UpdateRequest;
use App\Http\Requests\Api\User\NoteController\DeleteRequest;
use App\Interfaces\Eloquent\INoteService;

class NoteController extends Controller
{
    use HttpResponse;

    /**
     * @var $noteService
     */
    private $noteService;

    public function __construct(INoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    /**
     * @param GetByDateBetweenRequest $request
     */
    public function getByDateBetween(GetByDateBetweenRequest $request)
    {
        $response = $this->noteService->getByDateBetween(
            $request->user()->ID,
            $request->startDate,
            $request->endDate
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
        $response = $this->noteService->getById(
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
        $response = $this->noteService->create(
            $request->user()->ID,
            $request->date,
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
        $response = $this->noteService->update(
            $request->id,
            $request->date,
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
        $response = $this->noteService->delete(
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
