<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\UserCompanyConnectionController\GetUserCompaniesRequest;
use App\Http\Requests\Api\User\UserCompanyConnectionController\AttachUserCompanyRequest;
use App\Http\Requests\Api\User\UserCompanyConnectionController\DetachUserCompanyRequest;
use App\Http\Requests\Api\User\UserCompanyConnectionController\SyncUserCompaniesRequest;
use App\Http\Requests\Api\User\UserCompanyConnectionController\GetCompanyUsersRequest;
use App\Http\Requests\Api\User\UserCompanyConnectionController\AttachCompanyUserRequest;
use App\Http\Requests\Api\User\UserCompanyConnectionController\DetachCompanyUserRequest;
use App\Http\Requests\Api\User\UserCompanyConnectionController\SyncCompanyUsersRequest;
use App\Interfaces\Eloquent\IUserService;
use App\Interfaces\Eloquent\IFirmalarService;
use App\Core\HttpResponse;

class UserCompanyConnectionController extends Controller
{
    use HttpResponse;

    /**
     * @var $userService
     */
    private $userService;

    /**
     * @var $firmalarService
     */
    private $firmalarService;

    /**
     * @var IUserService $userService
     * @var IFirmalarService $firmalarService
     */
    public function __construct(
        IUserService     $userService,
        IFirmalarService $firmalarService
    )
    {
        $this->userService = $userService;
        $this->firmalarService = $firmalarService;
    }

    /**
     * @param GetUserCompaniesRequest $request
     */
    public function getUserCompanies(GetUserCompaniesRequest $request)
    {
        $response = $this->userService->getCompanies(
            $request->userId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param AttachUserCompanyRequest $request
     */
    public function attachUserCompany(AttachUserCompanyRequest $request)
    {
        $response = $this->userService->attachUserCompany(
            $request->userId,
            $request->companyId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param DetachUserCompanyRequest $request
     */
    public function detachUserCompany(DetachUserCompanyRequest $request)
    {
        $response = $this->userService->detachUserCompany(
            $request->userId,
            $request->companyId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param SyncUserCompaniesRequest $request
     */
    public function syncUserCompanies(SyncUserCompaniesRequest $request)
    {
        $response = $this->userService->syncUserCompanies(
            $request->userId,
            $request->companyIds
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetCompanyUsersRequest $request
     */
    public function getCompanyUsers(GetCompanyUsersRequest $request)
    {
        $response = $this->firmalarService->getCompanyUsers(
            $request->user()->ID
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param AttachCompanyUserRequest $request
     */
    public function attachCompanyUser(AttachCompanyUserRequest $request)
    {
        $response = $this->firmalarService->attachCompanyUser(
            $request->user()->ID
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param DetachCompanyUserRequest $request
     */
    public function detachCompanyUser(DetachCompanyUserRequest $request)
    {
        $response = $this->firmalarService->detachCompanyUser(
            $request->user()->ID
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param SyncCompanyUsersRequest $request
     */
    public function syncCompanyUsers(SyncCompanyUsersRequest $request)
    {
        $response = $this->firmalarService->syncCompanyUsers(
            $request->user()->ID
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
