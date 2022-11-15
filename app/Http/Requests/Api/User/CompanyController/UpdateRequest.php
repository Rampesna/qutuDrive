<?php

namespace App\Http\Requests\Api\User\CompanyController;

use App\Core\BaseApiRequest;

class UpdateRequest extends BaseApiRequest
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
            'title' => 'required',
            'taxNumber' => 'required',
            'name' => 'nullable',
            'surname' => 'nullable',
            'taxOffice' => 'nullable',
            'address' => 'nullable',
            'phone' => 'nullable',
            'email' => 'required',
            'dealerCode' => 'nullable',
            'eLedgerSourceType' => 'nullable',
        ];
    }
}
