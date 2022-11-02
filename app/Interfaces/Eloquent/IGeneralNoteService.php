<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IGeneralNoteService extends IEloquentService
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
     * @param string|null $title
     * @param string|null $note
     *
     * @return ServiceResponse
     */
    public function create(
        int    $companyId,
        string $title = null,
        string $note = null
    ): ServiceResponse;

    /**
     * @param int $id
     * @param string|null $title
     * @param string|null $note
     *
     * @return ServiceResponse
     */
    public function update(
        int    $id,
        string $title = null,
        string $note = null
    ): ServiceResponse;
}
