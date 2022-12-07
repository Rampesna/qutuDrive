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
            __('ServiceResponse/Eloquent/FormQuestionService.getAll.success'),
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
                __('ServiceResponse/Eloquent/FormQuestionService.getById.exists'),
                200,
                $formQuestion
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/FormQuestionService.getById.notFound'),
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
                __('ServiceResponse/Eloquent/FormQuestionService.delete.success'),
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
            __('ServiceResponse/Eloquent/FormQuestionService.getByFormIdWithAnswers.success'),
            200,
            FormQuestion::with([
                'answers'
            ])->where('form_id', $formId)->get()
        );
    }
}



