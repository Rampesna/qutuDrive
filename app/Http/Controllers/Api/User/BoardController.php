<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\BoardController\CreateRequest;
use App\Http\Requests\Api\User\BoardController\UpdateNameRequest;
use App\Http\Requests\Api\User\BoardController\UpdateOrderRequest;
use App\Http\Requests\Api\User\BoardController\DeleteRequest;
use App\Interfaces\Eloquent\IBoardService;
use App\Core\HttpResponse;

class BoardController extends Controller
{
    use HttpResponse;

    /**
     * @var $boardService
     */
    private $boardService;

    /**
     * @param IBoardService $boardService
     */
    public function __construct(IBoardService $boardService)
    {
        $this->boardService = $boardService;
    }

    /**
     * @param CreateRequest $request
     */
    public function create(CreateRequest $request)
    {
        $response = $this->boardService->create(
            $request->projectId,
            $request->name
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param UpdateNameRequest $request
     */
    public function updateName(UpdateNameRequest $request)
    {
        $response = $this->boardService->updateName(
            $request->id,
            $request->name
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param UpdateOrderRequest $request
     */
    public function updateOrder(UpdateOrderRequest $request)
    {
        $response = $this->boardService->updateOrder(
            $request->boards
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
        $response = $this->boardService->delete(
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
