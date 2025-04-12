<?php

namespace App\Modules\Users\Requests;

use App\Http\Requests\BaseGetRequestValidator;

class ListUsersRequest extends BaseGetRequestValidator
{
    public function rules(): array
    {
        $rules = [];
        return array_merge(parent::rules(), $rules);
    }
}
