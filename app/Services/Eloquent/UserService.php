<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\IUserService;
use App\Models\Eloquent\Kullanicilar;
use App\Core\ServiceResponse;

class UserService implements IUserService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All users',
            200,
            Kullanicilar::all()
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse
    {
        $user = Kullanicilar::find($id);
        if ($user) {
            return new ServiceResponse(
                true,
                'User',
                200,
                $user
            );
        } else {
            return new ServiceResponse(
                false,
                'User not found',
                404,
                null
            );
        }
    }

    /**
     * @param string $username
     * @param int|null $exceptId
     *
     * @return ServiceResponse
     */
    public function getByUsername(
        string $username,
        ?int   $exceptId = null
    ): ServiceResponse
    {
        $user = Kullanicilar::where('KULLANICIADI', $username);

        if ($exceptId) {
            $user->where('id', '!=', $exceptId);
        }

        $user = $user->first();

        if ($user) {
            return new ServiceResponse(
                true,
                'User',
                200,
                $user
            );
        } else {
            return new ServiceResponse(
                false,
                'User not found',
                404,
                null
            );
        }
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getProfile(
        int $id
    ): ServiceResponse
    {
        $user = Kullanicilar::find($id);
        if ($user) {
            return new ServiceResponse(
                true,
                'User',
                200,
                $user
            );
        } else {
            return new ServiceResponse(
                false,
                'User not found',
                404,
                null
            );
        }
    }

    /**
     * @param int $userId
     *
     * @return ServiceResponse
     */
    public function getCompanies(
        int $userId
    ): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            return new ServiceResponse(
                true,
                'User companies',
                200,
                $user->getData()->companies
            );
        } else {
            return $user;
        }
    }

    /**
     * @param int $userId
     * @param string $password
     *
     * @return ServiceResponse
     */
    public function checkPassword(
        int    $userId,
        string $password
    ): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            if ($user->getData()->KULLANICISIFRE == $password) {
                return new ServiceResponse(
                    true,
                    'Password is correct',
                    200,
                    null
                );
            } else {
                return new ServiceResponse(
                    false,
                    'Password is incorrect',
                    400,
                    null
                );
            }
        } else {
            return $user;
        }
    }

    /**
     * @param int $userId
     * @param array $companyIds
     *
     * @return ServiceResponse
     */
    public function setCompanies(
        int   $userId,
        array $companyIds
    ): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $user->getData()->companies()->sync($companyIds);
            return new ServiceResponse(
                true,
                'User companies set',
                200,
                $user->getData()
            );
        } else {
            return $user;
        }
    }

    /**
     * @param int $userId
     *
     * @return ServiceResponse
     */
    public function generateSanctumToken(
        int $userId
    ): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $token = $user->getData()->createToken('userApiToken')->plainTextToken;

            $user->getData()->api_token = $token;
            $user->getData()->save();

            return new ServiceResponse(
                true,
                'User api token generated',
                200,
                $token
            );
        } else {
            return new ServiceResponse(
                false,
                'User not found',
                404,
                null
            );
        }
    }

    /**
     * @return ServiceResponse
     */
    public function create(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'User created',
            200,
            null
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function update(
        int $id
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'User updated',
            200,
            null
        );
    }

    /**
     * @param int $userId
     * @param string $password
     *
     * @return ServiceResponse
     */
    public function updatePassword(
        int    $userId,
        string $password
    ): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $user->getData()->password = $password;
            $user->getData()->save();

            return new ServiceResponse(
                true,
                'User password updated',
                200,
                $user->getData()
            );
        } else {
            return $user;
        }
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function delete(
        int $id
    ): ServiceResponse
    {
        $user = $this->getById($id);
        if ($user->isSuccess()) {
            $user->getData()->delete();

            return new ServiceResponse(
                true,
                'User deleted',
                200,
                $user->getData()
            );
        } else {
            return $user;
        }
    }
}
