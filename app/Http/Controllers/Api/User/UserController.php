<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\UserController\LoginRequest;
use App\Interfaces\Eloquent\IUserService;
use App\Core\Response;

class UserController extends Controller
{
    use Response;

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
                return $this->error('Password is incorrect', 401);
            }

            return $this->success('User logged in successfully', [
                'token' => $this->userService->generateSanctumToken($user->getData()->ID)->getData()
            ]);
        } else {
            return $this->error(
                $user->getMessage(),
                $user->getStatusCode()
            );
        }
    }
}
