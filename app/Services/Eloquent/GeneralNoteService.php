<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IGeneralNoteService;
use App\Models\Eloquent\GeneralNote;

class GeneralNoteService implements IGeneralNoteService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/GeneralNoteService.getAll.success'),
            200,
            GeneralNote::all()
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
        $generalNote = GeneralNote::find($id);
        if ($generalNote) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/GeneralNoteService.getById.exists'),
                200,
                $generalNote
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/GeneralNoteService.getById.notFound'),
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
        $generalNote = $this->getById($id);
        if ($generalNote->isSuccess()) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/GeneralNoteService.delete.success'),
                200,
                $generalNote->getData()->delete()
            );
        } else {
            return $generalNote;
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
        $generalNotes = GeneralNote::where('company_id', $companyId);

        if ($keyword) {
            $generalNotes->where(function ($generalNotes) use ($keyword) {
                $generalNotes->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('note', 'like', '%' . $keyword . '%');
            });
        }

        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/GeneralNoteService.index.success'),
            200,
            [
                'totalCount' => $generalNotes->count(),
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'generalNotes' => $pageSize == -1 ?
                    $generalNotes->get() :
                    $generalNotes->skip($pageSize * $pageIndex)->take($pageSize)->get()
            ]
        );
    }

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
    ): ServiceResponse
    {
        $generalNote = new GeneralNote();
        $generalNote->company_id = $companyId;
        $generalNote->title = $title;
        $generalNote->note = $note;
        $generalNote->save();

        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/GeneralNoteService.create.success'),
            200,
            $generalNote
        );
    }

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
    ): ServiceResponse
    {
        $generalNote = $this->getById($id);
        if ($generalNote->isSuccess()) {
            $generalNote = $generalNote->getData();
            $generalNote->title = $title;
            $generalNote->note = $note;
            $generalNote->save();

            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/GeneralNoteService.update.success'),
                200,
                $generalNote
            );
        } else {
            return $generalNote;
        }
    }
}
