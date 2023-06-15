<?php

namespace App\Http\Requests\Api\User\EDefterDosyalarController;

use App\Core\BaseApiRequest;

class GetByDatesAndTypeIdsRequest extends BaseApiRequest
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
            'companyId' => 'required|integer',
            'year' => 'required',
            'month' => 'required',
            'typeIds' => 'required|array',
        ];
    }
}
