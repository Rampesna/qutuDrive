<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IFormQuestionService extends IEloquentService
{
    /**
     * @param int $formId
     *
     * @return ServiceResponse
     */
    public function getByFormIdWithAnswers(
        int $formId,
    ): ServiceResponse;
}
