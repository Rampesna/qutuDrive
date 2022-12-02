<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\IBoardService;
use App\Models\Eloquent\Board;
use App\Core\ServiceResponse;

class BoardService implements IBoardService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/BoardService.getAll.success'),
            200,
            Board::all()
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
        $board = Board::find($id);
        if ($board) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/BoardService.getById.exists'),
                200,
                $board
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/BoardService.getById.notFound'),
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
        $board = $this->getById($id);
        if ($board->isSuccess()) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/BoardService.delete.success'),
                200,
                $board->getData()->delete()
            );
        } else {
            return $board;
        }
    }

    /**
     * @param array $boards {
     * @return ServiceResponse
     * @var int $order
     * }
     *
     * @var int $id
     */
    public function updateOrder(
        array $boards
    ): ServiceResponse
    {
        foreach ($boards as $board) {
            $getBoard = $this->getById($board['id']);
            if ($getBoard->isSuccess()) {
                $getBoard->getData()->order = $board['order'];
                $getBoard->getData()->save();
            }
        }

        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/BoardService.updateOrder.success'),
            200,
            null
        );
    }

    /**
     * @param int $projectId
     * @param string|null $name
     *
     * @return ServiceResponse
     */
    public function create(
        int     $projectId,
        ?string $name
    ): ServiceResponse
    {
        $lastBoard = Board::where('project_id', $projectId)->orderBy('order', 'desc')->first();
        $board = new Board;
        $board->project_id = $projectId;
        $board->name = $name;
        $board->order = $lastBoard ? ($lastBoard->order + 1) : 1;
        $board->save();

        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/BoardService.create.success'),
            201,
            $board
        );
    }

    /**
     * @param int $id
     * @param string|null $name
     *
     * @return ServiceResponse
     */
    public function updateName(
        int     $id,
        ?string $name,
    ): ServiceResponse
    {
        $board = $this->getById($id);
        if ($board->isSuccess()) {
            $board->getData()->name = $name;
            $board->getData()->save();

            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/BoardService.updateName.success'),
                200,
                $board->getData()
            );
        } else {
            return $board;
        }
    }
}
