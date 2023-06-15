<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\EDefterDonemlerController\GetEDefterDonemRequest;
use App\Interfaces\Eloquent\IEDefterDonemlerService;

class EDefterDonemlerController extends Controller
{
    use HttpResponse;

    /**
     * @var $eDefterDonemlerService
     */
    private $eDefterDonemlerService;

    public function __construct(IEDefterDonemlerService $eDefterDonemlerService)
    {
        $this->eDefterDonemlerService = $eDefterDonemlerService;
    }

    /**
     * @param GetEDefterDonemRequest $request
     */
    public function getEDefterDonem(GetEDefterDonemRequest $request)
    {
        set_time_limit(86400);
        $response = $this->eDefterDonemlerService->getEDefterDonem(
            $request->companyId,
            $request->year,
            $request->month,
            $request->typeIds
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
