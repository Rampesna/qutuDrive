<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\PaketBilgileriController\GetAllRequest;
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
}
