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
            __('ServiceResponse/Eloquent/DirectoryService.getAll.success'),
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
                __('ServiceResponse/Eloquent/DirectoryService.getById.exists'),
                200,
                $directory
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/DirectoryService.getById.notFound'),
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
                __('ServiceResponse/Eloquent/DirectoryService.delete.success'),
                200,
                $directory->getData()->delete()
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
            __('ServiceResponse/Eloquent/DirectoryService.getByParentId.success'),
            200,
            Directory::where('company_id', $companyId)->where('parent_id', $parentId)->get()
        );
    }

    /**
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function getTrashed(
        int $companyId
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/DirectoryService.getTrashed.success'),
            200,
            Directory::onlyTrashed()->where('company_id', $companyId)->get()
        );
    }

    /**
     * @param array $directoryIds
     *
     * @return ServiceResponse
     */
    public function recoverTrashed(
        array $directoryIds
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/DirectoryService.recoverTrashed.success'),
            200,
            Directory::onlyTrashed()->whereIn('id', $directoryIds)->restore()
        );
    }

    /**
     * @param int|null $parentId
     * @param int $companyId
     * @param string $name
     *
     * @return ServiceResponse
     */
    public function create(
        ?int   $parentId,
        int    $companyId,
        string $name
    ): ServiceResponse
    {
        $directory = new Directory();
        $directory->parent_id = $parentId;
        $directory->company_id = $companyId;
        $directory->name = $name;
        $directory->save();

        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/DirectoryService.create.success'),
            201,
            $directory
        );
    }

    /**
     * @param int $id
     * @param string $name
     *
     * @return ServiceResponse
     */
    public function rename(
        int    $id,
        string $name
    ): ServiceResponse
    {
        $directory = $this->getById($id);
        if ($directory->isSuccess()) {
            $directory->getData()->name = $name;
            $directory->getData()->save();
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/DirectoryService.rename.success'),
                200,
                $directory->getData()
            );
        } else {
            return $directory;
        }
    }

    /**
     * @param int|null $parentId
     * @param array $directoryIds
     *
     * @return ServiceResponse
     */
    public function updateParentId(
        ?int  $parentId,
        array $directoryIds
    ): ServiceResponse
    {
        $directories = Directory::whereIn('id', $directoryIds)->update([
            'parent_id' => $parentId
        ]);

        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/DirectoryService.updateParentId.success'),
            200,
            $directories
        );
    }

    /**
     * @param array $directoryIds
     *
     * @return ServiceResponse
     */
    public function deleteBatch(
        array $directoryIds
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/DirectoryService.deleteBatch.success'),
            200,
            Directory::whereIn('id', $directoryIds)->delete()
        );
    }

    /**
     * @param array $directoryIds
     *
     * @return ServiceResponse
     */
    public function recover(
        array $directoryIds
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/DirectoryService.recover.success'),
            200,
            Directory::onlyTrashed()->whereIn('id', $directoryIds)->restore()
        );
    }
}
