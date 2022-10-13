<?php

namespace App\Http\Requests\Api\User\TaskController;

use App\Http\Requests\Api\BaseApiRequest;

class UpdateOrderRequest extends BaseApiRequest
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
            'tasks' => 'required|array',
        ];
    }
}
