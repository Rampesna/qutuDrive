<?php

namespace App\Http\Requests\Api\User\FormController;

use App\Core\BaseApiRequest;

class UpdateAccessibleRequest extends BaseApiRequest
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
            'id' => 'required|integer',
            'accessible' => 'required|boolean',
        ];
    }
}
