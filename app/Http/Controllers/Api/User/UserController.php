<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\UserController\GetAllPermissionsRequest;
use App\Http\Requests\Api\User\UserController\GetCompaniesRequest;
use App\Http\Requests\Api\User\UserController\SetSelectedCompanyRequest;
use App\Http\Requests\Api\User\UserController\CheckPasswordRequest;
use App\Http\Requests\Api\User\UserController\GetUserPermissionRequest;
use App\Http\Requests\Api\User\UserController\LoginRequest;
use App\Http\Requests\Api\User\UserController\RegisterRequest;
use App\Http\Requests\Api\User\UserController\GetAllRequest;
use App\Http\Requests\Api\User\UserController\JqxGridRequest;
use App\Http\Requests\Api\User\UserController\GetByCompanyIdRequest;
use App\Http\Requests\Api\User\UserController\GetByEmailRequest;
use App\Http\Requests\Api\User\UserController\GetByUsernameRequest;
use App\Http\Requests\Api\User\UserController\GetByIdRequest;
use App\Http\Requests\Api\User\UserController\GetProfileRequest;
use App\Http\Requests\Api\User\UserController\CreateRequest;
use App\Http\Requests\Api\User\UserController\SetPermissionsRequest;
use App\Http\Requests\Api\User\UserController\UpdateRequest;
use App\Http\Requests\Api\User\UserController\DeleteRequest;
use App\Http\Requests\Api\User\UserController\SendPasswordResetEmailRequest;
use App\Http\Requests\Api\User\UserController\ResetPasswordRequest;
use App\Http\Requests\Api\User\UserController\ChangeEmailRequest;
use App\Interfaces\Eloquent\IUserService;
use App\Interfaces\Eloquent\IFirmalarService;
use App\Core\HttpResponse;

class UserController extends Controller
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
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        $user = $this->userService->getByUsername($request->username);
        if ($user->isSuccess()) {
            if ($user->getData()->DURUM != 1) {
                return $this->httpResponse('User is not activated', 401);
            }

            if ($request->password != $user->getData()->KULLANICISIFRE) {
                return $this->httpResponse('Password is incorrect', 401);
            }

            return $this->httpResponse('User logged in successfully', 200, [
                'token' => $this->userService->generateSanctumToken($user->getData()->ID)->getData()
            ], true);
        } else {
            return $this->httpResponse(
                $user->getMessage(),
                $user->getStatusCode()
            );
        }
    }

    /**
     * @param RegisterRequest $request
     */
    public function register(RegisterRequest $request)
    {
        $company = $this->firmalarService->getByTaxNumber($request->taxNumber);
        if ($company->isSuccess()) {
            return $this->httpResponse(
                'This tax number is already registered',
                400
            );
        } else {
            $user = $this->userService->getByEmail($request->email);
            if ($user->isSuccess()) {
                return $this->httpResponse(
                    'This email address is already registered',
                    400
                );
            } else {
                $userByUsername = $this->userService->getByUsername($request->email);
                if ($userByUsername->isSuccess()) {
                    return $this->httpResponse(
                        'This username is already registered',
                        400
                    );
                } else {
                    $newCompany = $this->firmalarService->create(
                        $request->title,
                        $request->taxNumber,
                        $request->name,
                        $request->surname,
                        $request->taxOffice,
                        $request->address,
                        $request->phone,
                        $request->email,
                        $request->dealerCode,
                        $request->eLedgerSourceType ?? 1
                    );

                    if ($newCompany->isSuccess()) {
                        $newUser = $this->userService->create(
                            $request->email,
                            $request->password,
                            $request->name,
                            $request->surname,
                            $request->phone,
                            $request->email,
                            $request->taxNumber,
                            1,
                            $newCompany->getData()->ID,
                            0
                        );

                        if ($newUser->isSuccess()) {

                            $this->userService->setCompanies(
                                $newUser->getData()->ID,
                                [$newCompany->getData()->ID => [
                                    'FIRMAUNVAN' => $newCompany->getData()->FIRMAUNVAN,
                                    'DURUM' => 1
                                ]]
                            );

                            return $this->httpResponse(
                                'User registered successfully',
                                200,
                                [
                                    'token' => $this->userService->generateSanctumToken($newUser->getData()->ID)->getData()
                                ],
                                true
                            );
                        } else {
                            return $this->httpResponse(
                                $newUser->getMessage(),
                                $newUser->getStatusCode()
                            );
                        }
                    } else {
                        return $this->httpResponse(
                            $newCompany->getMessage(),
                            $newCompany->getStatusCode()
                        );
                    }
                }
            }
        }
    }

    /**
     * @param GetProfileRequest $request
     */
    public function getProfile(GetProfileRequest $request)
    {
        $response = $this->userService->getProfile(
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
     * @param GetCompaniesRequest $request
     */
    public function getCompanies(GetCompaniesRequest $request)
    {
        $response = $this->userService->getCompanies(
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
     * @param SetSelectedCompanyRequest $request
     */
    public function setSelectedCompany(SetSelectedCompanyRequest $request)
    {
        $response = $this->userService->setSelectedCompany(
            $request->user()->ID,
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
     * @param CheckPasswordRequest $request
     */
    public function checkPassword(CheckPasswordRequest $request)
    {
        $response = $this->userService->checkPassword(
            $request->user()->ID,
            $request->password
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetAllRequest $request
     */
    public function getAll(GetAllRequest $request)
    {
        $response = $this->userService->getAll();

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param JqxGridRequest $request
     */
    public function jqxGrid(JqxGridRequest $request)
    {
        $response = $this->userService->jqxGrid(
            $request
        );

        return response()->json($response->getData());
    }

    /**
     * @param GetByCompanyIdRequest $request
     */
    public function getByCompanyId(GetByCompanyIdRequest $request)
    {
        $response = $this->userService->getByCompanyId(
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
     * @param GetByEmailRequest $request
     */
    public function getByEmail(GetByEmailRequest $request)
    {
        $response = $this->userService->getByEmail(
            $request->email,
            $request->exceptId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetByUsernameRequest $request
     */
    public function getByUsername(GetByUsernameRequest $request)
    {
        $response = $this->userService->getByUsername(
            $request->username,
            $request->exceptId
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
        $response = $this->userService->getById(
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
        $response = $this->userService->create(
            $request->username,
            $request->password,
            $request->name,
            $request->surname,
            $request->phone,
            $request->email,
            $request->taxNumber,
            1,
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
     * @param UpdateRequest $request
     */
    public function update(UpdateRequest $request)
    {
        $response = $this->userService->update(
            $request->id,
            $request->username,
            $request->email,
            $request->name,
            $request->surname,
            $request->phone,
            $request->taxNumber,
            $request->password,
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
        $response = $this->userService->delete(
            $request->id
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function getUserPermission(GetUserPermissionRequest $request)
    {
        $response = $this->userService->getPermissions(
            $request->id
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function getAllPermissions(GetAllPermissionsRequest $request)
    {
        $response = $this->userService->getAllPermissions();
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function setPermissions(SetPermissionsRequest $request)
    {
        $response = $this->userService->setPermissions(
            $request->id,
            $request->permissions
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param SendPasswordResetEmailRequest $request
     * */
    public function sendPasswordResetEmail(SendPasswordResetEmailRequest $request)
    {
        $response = $this->userService->sendPasswordResetEmail(
            $request->email
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param ResetPasswordRequest $request
     * */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $response = $this->userService->resetPassword(
            $request->resetPasswordToken,
            $request->newPassword
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param ChangeEmailRequest $request
     * */
    public function changeEmail(ChangeEmailRequest $request)
    {
        $response = $this->userService->changeEmail(
            $request->user()->ID,
            $request->userId,
            $request->email,
            $request->file('petition')
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
