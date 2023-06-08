<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\PaketBilgileriController\GetAllRequest;
use App\Http\Requests\Api\User\PaketBilgileriController\GetByIdRequest;
use App\Http\Requests\Api\User\PaketBilgileriController\CreateRequest;
use App\Http\Requests\Api\User\PaketBilgileriController\UpdateRequest;
use App\Http\Requests\Api\User\PaketBilgileriController\DeleteRequest;
use App\Interfaces\Eloquent\IPaketBilgileriService;

class PaketBilgileriController extends Controller
{
    use HttpResponse;

    /**
     * @var $paketBilgileri
     */
    private $paketBilgileri;

    public function __construct(IPaketBilgileriService $paketBilgileriService)
    {
        $this->paketBilgileri = $paketBilgileriService;
    }

    /**
     * @param GetAllRequest $request
     */
    public function getAll(GetAllRequest $request)
    {
        $response = $this->paketBilgileri->getAll();

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
        $response = $this->paketBilgileri->getById(
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
        $response = $this->paketBilgileri->create(
            $request->dealerCode,
            $request->code,
            $request->name,
            $request->size,
            $request->price,
            $request->status
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
        $response = $this->paketBilgileri->update(
            $request->id,
            $request->dealerCode,
            $request->code,
            $request->name,
            $request->size,
            $request->price,
            $request->status
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
        $response = $this->paketBilgileri->delete(
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
