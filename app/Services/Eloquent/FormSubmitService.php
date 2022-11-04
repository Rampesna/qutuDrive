<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\FormSubmit;
use App\Interfaces\Eloquent\IFormSubmitService;
use Illuminate\Support\Str;

class FormSubmitService implements IFormSubmitService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All formSubmits',
            200,
            FormSubmit::all()
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
        $formSubmit = FormSubmit::find($id);
        if ($formSubmit) {
            return new ServiceResponse(
                true,
                'FormSubmit',
                200,
                $formSubmit
            );
        } else {
            return new ServiceResponse(
                false,
                'FormSubmit not found',
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
        $formSubmit = $this->getById($id);
        if ($formSubmit->isSuccess()) {
            return new ServiceResponse(
                true,
                'FormSubmit deleted',
                200,
                $formSubmit->getData()->delete()
            );
        } else {
            return $formSubmit;
        }
    }

    /**
     * @param int $formId
     * @param array $questionAnswers
     *
     * @return ServiceResponse
     */
    public function submit(
        int   $formId,
        array $questionAnswers
    ): ServiceResponse
    {
        $uuid = Str::uuid();
        foreach ($questionAnswers as $questionAnswer) {
            $formSubmit = new FormSubmit;
            $formSubmit->guid = $uuid;
            $formSubmit->form_id = $formId;
            $formSubmit->question_id = $questionAnswer['questionId'];
            $formSubmit->answer = $questionAnswer['answer'];
            $formSubmit->save();
        }

        return new ServiceResponse(
            true,
            'Form submitted',
            201,
            $formSubmit
        );
    }

    /**
     * @param int $formId
     *
     * @return ServiceResponse
     */
    public function getByFormId(
        int $formId
    ): ServiceResponse
    {
        $answers = [];
        $formSubmits = collect(
            FormSubmit::with([
                'form' => function ($query) use ($formId) {
                    $query->with([
                        'questions'
                    ]);
                }
            ])->where('form_id', $formId)->get()
        )->groupBy('guid');

        $questions = [];

        foreach ($formSubmits->first()[0]['form']->questions as $question) {
            $questions[] = [
                'id' => $question['id'],
                'name' => $question['name'],
            ];
        }

        foreach ($formSubmits as $guid => $formSubmit) {
            foreach ($questions as $question) {
                $answers[$guid][$question['name']] = $formSubmit->where('question_id', $question['id'])->first()['answer'];
            }
        }

        return new ServiceResponse(
            true,
            'Form submits',
            200,
            [
                'questions' => $questions,
                'answers' => $answers
            ]
        );
    }
}
