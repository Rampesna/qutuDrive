<?php

namespace App\Http\Requests\Api\Home\FormSubmitController;

use App\Core\BaseApiRequest;

class SubmitRequest extends BaseApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formId' => 'required|integer',
            'questionAnswers' => 'required|array',
            'questionAnswers.*.questionId' => 'required|integer',
            'questionAnswers.*.answer' => 'required',
        ];
    }
}
