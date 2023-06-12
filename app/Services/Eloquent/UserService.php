<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\IUserService;
use App\Mail\User\ForgotPasswordEmail;
use App\Models\Eloquent\Dilekceler;
use App\Models\Eloquent\Firmalar;
use App\Models\Eloquent\Kullanicilar;
use App\Core\ServiceResponse;
use App\Models\Eloquent\Permission;
use App\Services\JqxGrid\JqxGridService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService implements IUserService
{
    /**
     * @param Request $request
     *
     * @return ServiceResponse
     */
    public function jqxGrid(
        Request $request
    ): ServiceResponse
    {
        $jqxGridService = new JqxGridService(
            'kullanicilar',
            [
                'ID',
                'DURUM',
                'KULLANICIADI',
                'APIKEY',
                'AD',
                'SOYAD',
                'TELEFON',
                'MAIL',
                'TCNO',
                'KULLANICITIPI',
                'KAYITTARIHI',
            ],
            $request
        );

        $jqxGrid = $jqxGridService->jqxGrid();

        return new ServiceResponse(
            true,
            'jqxGrid success',
            200,
            [
                [
                    'TotalRows' => $jqxGrid['TotalRows'],
                    'Rows' => $jqxGrid['Rows']->map(function ($user) {
                        $user->DURUM = $user->DURUM === 1 ? '<span class="badge badge-light-success">AKTİF</span>' : '<span class="badge badge-light-danger">PASİF</span>';
                        return $user;
                    })
                ]
            ]
        );
    }

    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/UserService.getAll.success'),
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
                __('ServiceResponse/Eloquent/UserService.getById.exists'),
                200,
                $user
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/UserService.getById.notFound'),
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
                __('ServiceResponse/Eloquent/UserService.getByUsername.success'),
                200,
                $user
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/UserService.getByUsername.notFound'),
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
                __('ServiceResponse/Eloquent/UserService.getByEmail.success'),
                200,
                $user
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/UserService.getByEmail.notFound'),
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
                __('ServiceResponse/Eloquent/UserService.getProfile.success'),
                200,
                $user
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/UserService.getProfile.notFound'),
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
                __('ServiceResponse/Eloquent/UserService.getCompanies.success'),
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
    public function setSelectedCompany(
        int $userId,
        int $companyId
    ): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $company = Firmalar::find($companyId);
            if ($company) {
                $user->getData()->selected_company_id = $companyId;
                $user->getData()->save();
                return new ServiceResponse(
                    true,
                    'setSelectedCompany.success',
                    200,
                    [
                        'user' => $user->getData(),
                        'company' => $company,
                    ]
                );
            } else {
                return new ServiceResponse(
                    false,
                    'setSelectedCompany.notFound',
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
    public function checkUserCompany(
        int $userId,
        int $companyId
    ): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/UserService.checkUserCompany.success'),
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
                    __('ServiceResponse/Eloquent/UserService.attachUserCompany.success'),
                    200,
                    $user->getData()->companies
                );
            } else {
                return new ServiceResponse(
                    false,
                    __('ServiceResponse/Eloquent/UserService.attachUserCompany.companyNotFound'),
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
                    __('ServiceResponse/Eloquent/UserService.detachUserCompany.success'),
                    200,
                    $user->getData()->companies
                );
            } else {
                return new ServiceResponse(
                    false,
                    __('ServiceResponse/Eloquent/UserService.detachUserCompany.companyNotFound'),
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
                    __('ServiceResponse/Eloquent/UserService.checkPassword.success'),
                    200,
                    null
                );
            } else {
                return new ServiceResponse(
                    false,
                    __('ServiceResponse/Eloquent/UserService.checkPassword.incorrect'),
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
                __('ServiceResponse/Eloquent/UserService.setCompanies.success'),
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
            __('ServiceResponse/Eloquent/UserService.create.success'),
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

            $company = $user->getData()->companies()->first();

            if ($company) {
                $user->getData()->selected_company_id = $company->ID;
            }

            $user->getData()->api_token = $token;
            $user->getData()->save();

            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/UserService.generateSanctumToken.success'),
                200,
                $token
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/UserService.generateSanctumToken.notFound'),
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
            __('ServiceResponse/Eloquent/UserService.getByCompanyId.success'),
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
                __('ServiceResponse/Eloquent/UserService.update.success'),
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
                __('ServiceResponse/Eloquent/UserService.updatePassword.success'),
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
                __('ServiceResponse/Eloquent/UserService.delete.success'),
                200,
                $user->getData()
            );
        } else {
            return $user;
        }
    }

    public function getPermissions(int $userId): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $permissions = $user->getData()->permissions;


            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/UserService.getPermissions.success'),
                200,
                $permissions
            );
        } else {
            return $user;
        }
    }

    public function setPermissions(
        int   $userId,
        array $permissionIds
    ): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $user->getData()->permissions()->sync($permissionIds);
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/UserService.setPermissions.success'),
                200,
                $user->getData()
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/UserService.setPermissions.notFound'),
                404,
                null
            );
        }
    }

    public function getAllPermissions(): ServiceResponse
    {
        $permissions = Permission::all();
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/UserService.getAllPermissions.success'),
            200,
            $permissions
        );
    }


    /**
     * @param string $email
     */
    public function sendPasswordResetEmail(
        string $email
    ): ServiceResponse
    {
        $user = Kullanicilar::where('MAIL', $email)->first();
        if (!$user) {
            return new ServiceResponse(
                false,
                'User not found with this email',
                404,
                null
            );
        }

        $passwordResetService = app()->make(PasswordResetService::class);
        $checkPasswordReset = $passwordResetService->checkPasswordReset(
            'App\\Models\\Eloquent\\Kullanicilar',
            $user->ID,
            date('Y-m-d H:i:s', strtotime('-1 hour'))
        );

        if ($checkPasswordReset->isSuccess()) {
            return new ServiceResponse(
                false,
                'You can only send password reset email once in an hour',
                406,
                null
            );
        }

        $passwordReset = $passwordResetService->create(
            'App\\Models\\Eloquent\\Kullanicilar',
            $user->ID
        );

        Mail::to($email)->send(new ForgotPasswordEmail($passwordReset->getData()->token));

        return new ServiceResponse(
            true,
            'Email sent successfully',
            200,
            $passwordReset->getData()
        );
    }

    /**
     * @param string $resetPasswordToken
     * @param string $newPassword
     */
    public function resetPassword(
        string $resetPasswordToken,
        string $newPassword
    ): ServiceResponse
    {
        $passwordResetService = app()->make(PasswordResetService::class);
        $passwordReset = $passwordResetService->getByToken($resetPasswordToken);

        if (!$passwordReset->isSuccess()) {
            return $passwordReset;
        }

        $user = $passwordReset->getData()->relation;
        $user->KULLANICISIFRE = $newPassword;
        $user->save();

        $passwordResetService->setUsed($passwordReset->getData()->id);

        return new ServiceResponse(
            true,
            'Password reset successfully',
            200,
            $user
        );
    }

    /**
     * @param int $transactionUserId
     * @param int $userId
     * @param string $email
     * @param mixed $petitionFile
     */
    public function changeEmail(
        int    $transactionUserId,
        int    $userId,
        string $email,
        mixed  $petitionFile
    ): ServiceResponse
    {
        $petition = new Dilekceler;
        $petition->ISLEMIYAPANKULLANICI = $transactionUserId;
        $petition->DILEKCEYOLU = base64_encode(file_get_contents($petitionFile));
        $petition->TARIH = date('Y-m-d H:i:s');
        $petition->save();

        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $user->getData()->KULLANICIADI = $email;
            $user->getData()->MAIL = $email;
            $user->getData()->save();

            return new ServiceResponse(
                true,
                'Email changed successfully',
                200,
                $user->getData()
            );
        } else {
            return $user;
        }
    }
}
