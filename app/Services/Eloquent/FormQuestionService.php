<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\FormQuestion;
use App\Interfaces\Eloquent\IFormQuestionService;

class FormQuestionService implements IFormQuestionService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All form questions',
            200,
            FormQuestion::all()
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
        $formQuestion = FormQuestion::find($id);
        if ($formQuestion) {
            return new ServiceResponse(
                true,
                'Form question',
                200,
                $formQuestion
            );
        } else {
            return new ServiceResponse(
                false,
                'Form question not found',
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
        $formQuestion = $this->getById($id);
        if ($formQuestion->isSuccess()) {
            return new ServiceResponse(
                true,
                'Form question deleted',
                200,
                $formQuestion->getData()->delete()
            );
        } else {
            return $formQuestion;
        }
    }

    /**
     * @param int $formId
     *
     * @return ServiceResponse
     */
    public function getByFormIdWithAnswers(
        int $formId
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Form questions with answers',
            200,
            FormQuestion::with([
                'answers'
            ])->where('form_id', $formId)->get()
        );
    }
}



