<?php

namespace App\Http\Requests\Api\User\ProjectController;

use App\Http\Requests\Api\BaseApiRequest;
use Illuminate\Http\Request;

class IndexRequest extends BaseApiRequest
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
            'pageIndex' => 'required|integer|min:0',
            'pageSize' => 'required|integer',
            'orderBy' => 'required|string|in:id,name,created_at,updated_at',
            'orderType' => 'required|string|in:asc,desc',
            'with' => 'nullable|array',
            'with.*' => 'nullable|string|in:company,status',
        ];
    }
}
