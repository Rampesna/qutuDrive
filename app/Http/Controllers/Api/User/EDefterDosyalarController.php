<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\EDefterDosyalarController\GetByDonemIdRequest;
use App\Interfaces\Eloquent\IEDefterDosyalarService;

class EDefterDosyalarController extends Controller
{
    use HttpResponse;

    /**
     * @var $eDefterDosyalarService
     */
    private $eDefterDosyalarService;

    public function __construct(IEDefterDosyalarService $eDefterDosyalarService)
    {
        $this->eDefterDosyalarService = $eDefterDosyalarService;
    }

    /**
     * @param GetByDonemIdRequest $request
     */
    public function getByDonemId(GetByDonemIdRequest $request)
    {
        $response = $this->eDefterDosyalarService->getByDonemId(
            $request->donemId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
