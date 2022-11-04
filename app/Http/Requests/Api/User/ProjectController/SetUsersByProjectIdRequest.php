<?php

namespace App\Http\Requests\Api\User\ProjectController;

use App\Core\BaseApiRequest;

class SetUsersByProjectIdRequest extends BaseApiRequest
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
            'projectId' => 'required',
            'userIds' => 'required|array',
            'userIds.*' => 'required|integer',
        ];
    }
}
