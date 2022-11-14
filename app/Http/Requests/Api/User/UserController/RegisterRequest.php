<?php

namespace App\Http\Requests\Api\User\UserController;

use App\Core\BaseApiRequest;

class RegisterRequest extends BaseApiRequest
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
            'name' => 'required',
            'surname' => 'required',
            'companyType' => 'required|integer',
            'taxNumber' => 'required|min:10|max:11',
            'taxOffice' => 'required',
            'title' => 'required',
            'phone' => 'nullable',
            'email' => 'required|email',
            'address' => 'nullable',
            'password' => 'required',
        ];
    }
}
