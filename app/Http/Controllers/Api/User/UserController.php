<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\UserController\GetCompaniesRequest;
use App\Http\Requests\Api\User\UserController\ResetPasswordRequest;
use App\Http\Requests\Api\User\UserController\SendPasswordResetEmailRequest;
use App\Http\Requests\Api\User\UserController\SetCompaniesRequest;
use App\Http\Requests\Api\User\UserController\SetUserCompaniesRequest;
use App\Http\Requests\Api\User\UserController\SetSingleCompanyRequest;
use App\Http\Requests\Api\User\UserController\GetSelectedCompaniesRequest;
use App\Http\Requests\Api\User\UserController\SetSelectedCompaniesRequest;
use App\Http\Requests\Api\User\UserController\LoginRequest;
use App\Http\Requests\Api\User\UserController\GetProfileRequest;
use App\Http\Requests\Api\User\UserController\SwapThemeRequest;
use App\Http\Requests\Api\User\UserController\UpdatePasswordRequest;
use App\Http\Requests\Api\User\UserController\GetAllRequest;
use App\Http\Requests\Api\User\UserController\GetByIdRequest;
use App\Http\Requests\Api\User\UserController\GetByEmailRequest;
use App\Http\Requests\Api\User\UserController\CreateRequest;
use App\Http\Requests\Api\User\UserController\UpdateRequest;
use App\Http\Requests\Api\User\UserController\SetSuspendRequest;
use App\Http\Requests\Api\User\UserController\DeleteRequest;
use App\Interfaces\Eloquent\IPasswordResetService;
use App\Interfaces\Eloquent\IUserService;
use App\Mail\User\ForgotPasswordEmail;
use App\Models\Eloquent\Kullanicilar;
use App\Core\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
