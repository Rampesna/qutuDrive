<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\UserController\GetCompaniesRequest;
use App\Http\Requests\Api\User\UserController\LoginRequest;
use App\Interfaces\Eloquent\IUserService;
use App\Core\HttpResponse;

class UserController extends Controller
{
    use HttpResponse;

    /**
     * @var $userService
     */
    private $userService;

    /**
     * @var $passwordResetService
     */
    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        $user = $this->userService->getByUsername($request->username);
        if ($user->isSuccess()) {
            if (!checkPassword($request->password, $user->getData()->KULLANICISIFRE)) {
                return $this->httpResponse('Password is incorrect', 401);
            }

            return $this->httpResponse('User logged in successfully', 200, [
                'token' => $this->userService->generateSanctumToken($user->getData()->ID)->getData()
            ]);
        } else {
            return $this->httpResponse(
                $user->getMessage(),
                $user->getStatusCode()
            );
        }
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
}
