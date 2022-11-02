<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IPasswordService extends IEloquentService
{
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
    ): ServiceResponse;

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
    ): ServiceResponse;

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
    ): ServiceResponse;
}
