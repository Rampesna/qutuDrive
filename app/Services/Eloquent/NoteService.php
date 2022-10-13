<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\Note;
use App\Interfaces\Eloquent\INoteService;

class NoteService implements INoteService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All notes',
            200,
            Note::all()
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
        $note = Note::find($id);
        if ($note) {
            return new ServiceResponse(
                true,
                'Note',
                200,
                $note
            );
        }
        return new ServiceResponse(
            false,
            'Note not found',
            404,
            null
        );
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
        $note = $this->getById($id);
        if ($note->isSuccess()) {
            return new ServiceResponse(
                true,
                'Note deleted',
                200,
                $note->getData()->delete()
            );
        } else {
            return $note;
        }
    }

    /**
     * @param int $userId
     * @param string $startDate
     * @param string $endDate
     *
     * @return ServiceResponse
     */
    public function getByDateBetween(
        int    $userId,
        string $startDate,
        string $endDate
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Notes',
            200,
            Note::where('user_id', $userId)->whereBetween('date', [$startDate, $endDate])->get()
        );
    }

    /**
     * @param int $userId
     * @param string|null $title
     * @param string|null $noteString
     *
     * @return ServiceResponse
     */
    public function create(
        int    $userId,
        string $date,
        string $title = null,
        string $noteString = null
    ): ServiceResponse
    {
        $note = new Note;
        $note->user_id = $userId;
        $note->date = $date;
        $note->title = $title;
        $note->note = $noteString;
        $note->save();

        return new ServiceResponse(
            true,
            'Note created',
            201,
            $note
        );
    }

    /**
     * @param int $id
     * @param string|null $title
     * @param string|null $noteString
     *
     * @return ServiceResponse
     */
    public function update(
        int    $id,
        string $date,
        string $title = null,
        string $noteString = null
    ): ServiceResponse
    {
        $note = $this->getById($id);
        if ($note->isSuccess()) {
            $note = $note->getData();
            $note->date = $date;
            $note->title = $title;
            $note->note = $noteString;
            $note->save();

            return new ServiceResponse(
                true,
                'Note updated',
                200,
                $note
            );
        } else {
            return $note;
        }
    }
}
