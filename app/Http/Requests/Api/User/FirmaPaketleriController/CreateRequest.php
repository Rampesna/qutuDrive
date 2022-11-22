<?php

namespace App\Http\Requests\Api\User\FirmaPaketleriController;

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
            'companyId' => 'required|integer',
            'packageCode' => 'required|string',
            'packageName' => 'required|string',
            'packageSize' => 'required|string',
            'packagePrice' => 'required|string',
            'startDate' => 'required|string',
            'endDate' => 'required|string',
            'status' => 'required|integer',
            'paymentType' => 'required|integer',
        ];
    }
}
