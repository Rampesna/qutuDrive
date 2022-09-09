<?php

namespace App\Http\Requests\Api\User\UserController;

use App\Http\Requests\Api\BaseApiRequest;

class CreateRequest extends BaseApiRequest
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
            'roleId' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable',
            'identity' => 'nullable',
        ];
    }
}
