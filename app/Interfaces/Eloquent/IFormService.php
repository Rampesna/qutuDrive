<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IFormService extends IEloquentService
{
    /**
     * @param int $companyId
     * @param int $pageIndex
     * @param int $pageSize
     * @param string|null $keyword
     *
     * @return ServiceResponse
     */
    public function getByCompanyId(
        int         $companyId,
        int         $pageIndex,
        int         $pageSize,
        string|null $keyword = null
    ): ServiceResponse;

    /**
     * @param int $companyId
     * @param string $name
     * @param string|null $title
     * @param string|null $description
     *
     * @return ServiceResponse
     */
    public function create(
        int         $companyId,
        string      $name,
        string|null $title = null,
        string|null $description = null
    ): ServiceResponse;

    /**
     * @param int $id
     * @param string $name
     * @param string|null $title
     * @param string|null $description
     *
     * @return ServiceResponse
     */
    public function update(
        int         $id,
        string      $name,
        string|null $title = null,
        string|null $description = null
    ): ServiceResponse;

    /**
     * @param int $id
     * @param bool $accessible
     *
     * @return ServiceResponse
     */
    public function updateAccessible(
        int  $id,
        bool $accessible
    ): ServiceResponse;

    /**
     * @param int $formId
     * @param array|null $formQuestions
     *
     * @return ServiceResponse
     */
    public function createFormQuestions(
        int    $formId,
        ?array $formQuestions
    ): ServiceResponse;

    /**
     * @param int $formId
     *
     * @return ServiceResponse
     */
    public function getShareLink(
        int $formId
    ): ServiceResponse;
}
