<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IUserService extends IEloquentService
{
    /**
     * @param string $username
     * @param int|null $exceptId
     *
     * @return ServiceResponse
     */
    public function getByUsername(
        string $username,
        ?int   $exceptId = null
    ): ServiceResponse;

    /**
     * @param string $email
     * @param int|null $exceptId
     *
     * @return ServiceResponse
     */
    public function getByEmail(
        string $email,
        ?int   $exceptId = null
    ): ServiceResponse;

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getProfile(
        int $id
    ): ServiceResponse;

    /**
     * @param int $userId
     *
     * @return ServiceResponse
     */
    public function getCompanies(
        int $userId
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function checkUserCompany(
        int $userId,
        int $companyId
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function attachUserCompany(
        int $userId,
        int $companyId
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function detachUserCompany(
        int $userId,
        int $companyId
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param string $password
     *
     * @return ServiceResponse
     */
    public function checkPassword(
        int    $userId,
        string $password
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param array $companyIds
     *
     * @return ServiceResponse
     */
    public function setCompanies(
        int   $userId,
        array $companyIds
    ): ServiceResponse;

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
    ): ServiceResponse;

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
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param string $password
     *
     * @return ServiceResponse
     */
    public function updatePassword(
        int    $userId,
        string $password
    ): ServiceResponse;

    /**
     * @param int $userId
     *
     * @return ServiceResponse
     */
    public function generateSanctumToken(
        int $userId
    ): ServiceResponse;

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
    ): ServiceResponse;

    public function getPermissions(
        int $userId
    ): ServiceResponse;

    public function setPermissions(
        int   $userId,
        array $permissionIds
    ): ServiceResponse;

    public function getAllPermissions(
    ): ServiceResponse;
}
