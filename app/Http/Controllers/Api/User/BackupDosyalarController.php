<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\BackupDosyalarController\GetByCompanyIdRequest;
use App\Interfaces\Eloquent\IBackupDosyalarService;

class BackupDosyalarController extends Controller
{
    use HttpResponse;

    /**
     * @var $backupDosyalarService
     */
    private $backupDosyalarService;

    public function __construct(IBackupDosyalarService $backupDosyalarService)
    {
        $this->backupDosyalarService = $backupDosyalarService;
    }

    /**
     * @param GetByCompanyIdRequest $request
     */
    public function getByCompanyId(GetByCompanyIdRequest $request)
    {
        $response = $this->backupDosyalarService->getByCompanyId(
            $request->companyId,
            $request->keyword
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
