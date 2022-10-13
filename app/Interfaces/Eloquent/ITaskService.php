<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface ITaskService extends IEloquentService
{
    /**
     * @param int $boardId
     * @param string $name
     *
     * @return ServiceResponse
     */
    public function create(
        int    $boardId,
        string $name
    ): ServiceResponse;

    /**
     * @param int $taskId
     * @param int $boardId
     *
     * @return ServiceResponse
     */
    public function updateBoard(
        int $taskId,
        int $boardId
    ): ServiceResponse;

    /**
     * @param array $taskList
     *
     * @return ServiceResponse
     */
    public function updateOrder(
        array $taskList
    ): ServiceResponse;

    /**
     * @param int $id
     * @param array $parameters
     *
     * @return ServiceResponse
     */
    public function updateByParameters(
        int   $id,
        array $parameters
    ): ServiceResponse;

    /**
     * @param int $taskId
     *
     * @return ServiceResponse
     */
    public function getFilesById(
        int $taskId
    ): ServiceResponse;

    /**
     * @param int $taskId
     *
     * @return ServiceResponse
     */
    public function getSubTasksById(
        int $taskId
    ): ServiceResponse;

    /**
     * @param int $taskId
     *
     * @return ServiceResponse
     */
    public function getCommentsById(
        int $taskId
    ): ServiceResponse;
}
