<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;

use App\Core\HttpResponse;
use App\Http\Requests\Api\User\VideoController\CreateRequest;
use App\Http\Requests\Api\User\VideoController\DeleteRequest;
use App\Http\Requests\Api\User\VideoController\GetAllRequest;
use App\Http\Requests\Api\User\VideoController\GetByIdRequest;
use App\Http\Requests\Api\User\VideoController\UpdateRequest;
use App\Interfaces\Eloquent\IVideoService;

/**
 *
 */
class VideoController extends Controller
{
    use HttpResponse;

    /**
     * @var IVideoService
     */
    private $videoService;

    /**
     * @param IVideoService $videoService
     */
    public function __construct(IVideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    /**
     * @param GetAllRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(GetAllRequest $request)
    {
        $response = $this->videoService->getAll();
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetByIdRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getById(GetByIdRequest $request)
    {
        $response = $this->videoService->getById($request->id);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteRequest $request)
    {
        $response = $this->videoService->delete($request->id);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRequest $request)
    {
        $response = $this->videoService->create($request->name, $request->url);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }


    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $response = $this->videoService->update($request->id, $request->name, $request->url);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }


}
