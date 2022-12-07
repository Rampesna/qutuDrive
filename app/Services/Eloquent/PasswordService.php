<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\Password;
use App\Interfaces\Eloquent\IPasswordService;

class PasswordService implements IPasswordService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/PasswordService.getAll.success'),
            200,
            Password::all()
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
        $password = Password::find($id);
        if ($password) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/PasswordService.getById.exists'),
                200,
                $password
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/PasswordService.getById.notFound'),
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
    public function delete(
        int $id
    ): ServiceResponse
    {
        $password = $this->getById($id);
        if ($password->isSuccess()) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/PasswordService.delete.success'),
                200,
                $password->getData()->delete()
            );
        } else {
            return $password;
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
    public function index(
        int     $companyId,
        int     $pageIndex,
        int     $pageSize,
        ?string $keyword
    ): ServiceResponse
    {
        $passwords = Password::where('company_id', $companyId);

        if ($keyword) {
            $passwords->where(function ($passwords) use ($keyword) {
                $passwords->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('link', 'like', '%' . $keyword . '%')
                    ->orWhere('username', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/PasswordService.index.success'),
            200,
            [
                'totalCount' => $passwords->count(),
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'passwords' => $pageSize == -1 ?
                    $passwords->get() :
                    $passwords->skip($pageSize * $pageIndex)->take($pageSize)->get()
            ]
        );
    }

    /**
     * @param int $companyId
     * @param string $name
     * @param string $link
     * @param string $username
     * @param string $passwordString
     * @param string|null $description
     *
     * @return ServiceResponse
     */
    public function create(
        int    $companyId,
        string $name,
        string $link,
        string $username,
        string $passwordString,
        string $description = null
    ): ServiceResponse
    {
        $password = new Password;
        $password->company_id = $companyId;
        $password->name = $name;
        $password->link = $link;
        $password->username = $username;
        $password->password = $passwordString;
        $password->description = $description;
        $password->save();

        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/PasswordService.create.success'),
            201,
            $password
        );
    }

    /**
     * @param int $companyId
     * @param string $name
     * @param string $link
     * @param string $username
     * @param string $passwordString
     * @param string|null $description
     *
     * @return ServiceResponse
     */
    public function update(
        int    $id,
        string $name,
        string $link,
        string $username,
        string $passwordString,
        string $description = null
    ): ServiceResponse
    {
        $password = $this->getById($id);
        if ($password->isSuccess()) {
            $password->getData()->name = $name;
            $password->getData()->link = $link;
            $password->getData()->username = $username;
            $password->getData()->password = $passwordString;
            $password->getData()->description = $description;
            $password->getData()->save();

            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/PasswordService.update.success'),
                200,
                $password
            );
        } else {
            return $password;
        }
    }
}
