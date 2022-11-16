<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\IUserService;
use App\Models\Eloquent\Firmalar;
use App\Models\Eloquent\Kullanicilar;
use App\Core\ServiceResponse;
use Illuminate\Support\Str;

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
     * @param string $email
     * @param int|null $exceptId
     *
     * @return ServiceResponse
     */
    public function getByEmail(
        string $email,
        ?int   $exceptId = null
    ): ServiceResponse
    {
        $user = Kullanicilar::where('MAIL', $email);

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
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function checkUserCompany(
        int $userId,
        int $companyId
    ): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            return new ServiceResponse(
                true,
                'User company',
                200,
                $user->getData()->companies->contains($companyId)
            );
        } else {
            return $user;
        }
    }

    /**
     * @param int $userId
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function attachUserCompany(
        int $userId,
        int $companyId
    ): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $company = Firmalar::find($companyId);
            if ($company) {
                $user->getData()->companies()->attach($company);
                return new ServiceResponse(
                    true,
                    'User company attached',
                    200,
                    $user->getData()->companies
                );
            } else {
                return new ServiceResponse(
                    false,
                    'Company not found',
                    404,
                    null
                );
            }
        } else {
            return $user;
        }
    }

    /**
     * @param int $userId
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function detachUserCompany(
        int $userId,
        int $companyId
    ): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $company = Firmalar::find($companyId);
            if ($company) {
                $user->getData()->companies()->detach($company);
                return new ServiceResponse(
                    true,
                    'User company detached',
                    200,
                    $user->getData()->companies
                );
            } else {
                return new ServiceResponse(
                    false,
                    'Company not found',
                    404,
                    null
                );
            }
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
     * @param string $username
     * @param string $password
     * @param string $name
     * @param string $surname
     * @param string|null $phone
     * @param string $email
     * @param string|null $taxNumber
     * @param string $userType
     * @param int|null $selectedCompanyId
     *
     * @return ServiceResponse
     */
    public function create(
        string  $username,
        string  $password,
        string  $name,
        string  $surname,
        ?string $phone,
        string  $email,
        ?string $taxNumber,
        string  $userType,
        ?int    $selectedCompanyId
    ): ServiceResponse
    {
        $user = new Kullanicilar;
        $user->APIKEY = Str::uuid();
        $user->KULLANICIADI = $username;
        $user->KULLANICISIFRE = $password;
        $user->AD = $name;
        $user->SOYAD = $surname;
        $user->TELEFON = $phone;
        $user->MAIL = $email;
        $user->TCNO = $taxNumber;
        $user->DURUM = 1;
        $user->KULLANICITIPI = $userType;
        $user->KAYITTARIHI = date('Y-m-d H:i:s');
        if ($selectedCompanyId) $user->selected_company_id = $selectedCompanyId;
        $user->save();

        return new ServiceResponse(
            true,
            'User created',
            201,
            $user
        );
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
     * @param int $companyId
     * @param int $pageIndex
     * @param int $pageSize
     * @param string|null $keyword
     *
     * @return ServiceResponse
     */
    public function getByCompanyId(
        int     $companyId,
        int     $pageIndex,
        int     $pageSize,
        ?string $keyword = null
    ): ServiceResponse
    {
        $users = Kullanicilar::whereIn('ID', Firmalar::find($companyId)->users->pluck('ID'));

        if ($keyword) {
            $users->where(function ($users) use ($keyword) {
                $users->where('KULLANICIADI', 'like', '%' . $keyword . '%')
                    ->orWhere('AD', 'like', '%' . $keyword . '%')
                    ->orWhere('SOYAD', 'like', '%' . $keyword . '%')
                    ->orWhere('TELEFON', 'like', '%' . $keyword . '%')
                    ->orWhere('MAIL', 'like', '%' . $keyword . '%')
                    ->orWhere('TCNO', 'like', '%' . $keyword . '%');
            });
        }

        return new ServiceResponse(
            true,
            'Users',
            200,
            [
                'totalCount' => $users->count(),
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'users' => $pageSize == -1 ?
                    $users->get() :
                    $users->skip($pageSize * $pageIndex)->take($pageSize)->get()
            ]
        );
    }

    /**
     * @param int $id
     * @param string $username
     * @param string $email
     * @param string $name
     * @param string $surname
     * @param string|null $phone
     * @param string|null $taxNumber
     * @param string|null $password
     * @param int $status
     *
     * @return ServiceResponse
     */
    public function update(
        int     $id,
        string  $username,
        string  $email,
        string  $name,
        string  $surname,
        ?string $phone,
        ?string $taxNumber,
        ?string $password,
        int     $status
    ): ServiceResponse
    {
        $user = $this->getById($id);
        if ($user->isSuccess()) {
            $user->getData()->KULLANICIADI = $username;
            $user->getData()->MAIL = $email;
            $user->getData()->AD = $name;
            $user->getData()->SOYAD = $surname;
            $user->getData()->TELEFON = $phone;
            $user->getData()->TCNO = $taxNumber;
            if ($password) $user->getData()->KULLANICISIFRE = $password;
            $user->getData()->DURUM = $status;
            $user->getData()->save();

            return new ServiceResponse(
                true,
                'User updated',
                200,
                $user->getData()
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
