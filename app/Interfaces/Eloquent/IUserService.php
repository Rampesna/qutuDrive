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
     * @param array $companyIds
     *
     * @return ServiceResponse
     */
    public function setCompanies(
        int   $userId,
        array $companyIds
    ): ServiceResponse;

    /**
     *
     * @return ServiceResponse
     */
    public function create(): ServiceResponse;

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function update(
        int $id,
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
     * @param int $userId
     *
     * @return ServiceResponse
     */
    public function getProjects(
        int $userId
    ): ServiceResponse;
}
