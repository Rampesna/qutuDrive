<?php

namespace App\Http\Requests\Api\User\CompanyController;

use App\Core\BaseApiRequest;

class GetByTaxNumberRequest extends BaseApiRequest
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
            'taxNumber' => 'required|min:10|max:11',
            'exceptId' => 'nullable|integer'
        ];
    }
}
