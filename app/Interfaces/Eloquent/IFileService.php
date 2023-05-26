<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IFileService extends IEloquentService
{
    /**
     * @param int $relationId
     * @param string $relationType
     * @param string|null $name
     * @param string|null $mimeType
     * @param string|null $icon
     * @param int $typeId
     * @param string $fullPath
     * @param float|null $fileSize
     * @param string|null $uuid
     * @param mixed $directoryId
     *
     * @return ServiceResponse
     */
    public function create(
        int         $relationId,
        string      $relationType,
        string      $name = null,
        string      $mimeType = null,
        string      $icon = null,
        int         $typeId,
        string      $fullPath,
        float       $fileSize = null,
        string|null $uuid = null,
        mixed       $directoryId = null
    ): ServiceResponse;

    /**
     * @param int|null $directoryId
     * @param int $relationId
     * @param string $relationType
     *
     * @return ServiceResponse
     */
    public function getByRelation(
        ?int   $directoryId,
        int    $relationId,
        string $relationType
    ): ServiceResponse;

    /**
     * @param int $relationId
     * @param string $relationType
     *
     * @return ServiceResponse
     */
    public function getTrashedByRelation(
        int    $relationId,
        string $relationType
    ): ServiceResponse;

    /**
     * @param int $userId
     *
     * @return ServiceResponse
     */
    public function getDatabaseBackups(
        int $userId
    ): ServiceResponse;

    /**
     * @param int|null $directoryId
     * @param array $fileIds
     *
     * @return ServiceResponse
     */
    public function updateDirectoryId(
        ?int  $directoryId,
        array $fileIds
    ): ServiceResponse;

    /**
     * @param array $fileIds
     *
     * @return ServiceResponse
     */
    public function deleteBatch(
        array $fileIds
    ): ServiceResponse;

    /**
     * @param array $fileIds
     *
     * @return ServiceResponse
     */
    public function recover(
        array $fileIds
    ): ServiceResponse;
}
