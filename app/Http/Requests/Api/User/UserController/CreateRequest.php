<?php

namespace App\Http\Requests\Api\User\UserController;

use App\Core\BaseApiRequest;

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
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|string',
            'name' => 'required|string',
            'surname' => 'required|string',
            'phone' => 'nullable|string',
            'companyId' => 'nullable|integer',
        ];
    }
}
