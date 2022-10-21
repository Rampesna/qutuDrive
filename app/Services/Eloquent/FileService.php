<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\IFileService;
use App\Models\Eloquent\File;
use App\Core\ServiceResponse;

class FileService implements IFileService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All files',
            200,
            File::all()
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
        $file = File::find($id);
        if ($file) {
            return new ServiceResponse(
                true,
                'File',
                200,
                $file
            );
        } else {
            return new ServiceResponse(
                false,
                'File not found',
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
        $fileResponse = $this->getById($id);
        if ($fileResponse->isSuccess()) {
            return new ServiceResponse(
                true,
                'File deleted',
                200,
                $fileResponse->getData()->delete()
            );
        } else {
            return $fileResponse;
        }
    }

    /**
     * @param int $relationId
     * @param string $relationType
     * @param string|null $name
     * @param string|null $mimeType
     * @param string|null $icon
     * @param int $typeId
     * @param string $fullPath
     * @param float|null $fileSize
     *
     * @return ServiceResponse
     */
    public function create(
        int    $relationId,
        string $relationType,
        string $name = null,
        string $mimeType = null,
        string $icon = null,
        int    $typeId,
        string $fullPath,
        float  $fileSize = null
    ): ServiceResponse
    {
        $file = new File();
        $file->relation_id = $relationId;
        $file->relation_type = $relationType;
        $file->name = $name;
        $file->mime_type = $mimeType;
        $file->icon = $icon;
        $file->type_id = $typeId;
        $file->full_path = $fullPath;
        $file->file_size = $fileSize;
        $file->save();

        return new ServiceResponse(
            true,
            'File created',
            201,
            $file
        );
    }

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
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Files',
            200,
            File::where('directory_id', $directoryId)->where('relation_id', $relationId)->where('relation_type', $relationType)->get()
        );
    }

    /**
     * @param int $userId
     *
     * @return ServiceResponse
     */
    public function getDatabaseBackups(
        int $userId
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Database backups',
            200,
            File::where('relation_id', $userId)->where('relation_type', 'App\\Models\\Eloquent\\Kullanicilar')->where('type_id', 2)->get()
        );
    }
}
