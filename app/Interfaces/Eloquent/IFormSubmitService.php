<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IFormSubmitService extends IEloquentService
{
    /**
     * @param int $formId
     * @param array $questionAnswers
     *
     * @return ServiceResponse
     */
    public function submit(
        int   $formId,
        array $questionAnswers
    ): ServiceResponse;

    /**
     * @param int $formId
     *
     * @return ServiceResponse
     */
    public function getByFormId(
        int $formId
    ): ServiceResponse;
}
