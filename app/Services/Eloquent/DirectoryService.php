<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IDirectoryService;
use App\Models\Eloquent\Directory;

class DirectoryService implements IDirectoryService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All directories',
            200,
            Directory::all()
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
        $directory = Directory::find($id);
        if ($directory) {
            return new ServiceResponse(
                true,
                'Directory',
                200,
                $directory
            );
        } else {
            return new ServiceResponse(
                false,
                'Directory not found',
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
        $directory = $this->getById($id);
        if ($directory->isSuccess()) {
            return new ServiceResponse(
                true,
                'Directory deleted successfully',
                200,
                $directory->getData()->delete
            );
        } else {
            return $directory;
        }
    }

    /**
     * @param int $companyId
     * @param int|null $parentId
     *
     * @return ServiceResponse
     */
    public function getByParentId(
        int  $companyId,
        ?int $parentId = null
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Directories',
            200,
            Directory::where('company_id', $companyId)->where('parent_id', $parentId)->get()
        );
    }
}
