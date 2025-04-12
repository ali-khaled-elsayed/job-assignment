<?php

namespace App\Modules\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Modules\Shared\Enums\LanguagesEnum;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'fulfillmentCenterId' => 'required|integer|min:1|exists:fulfillment_centers,id',
            'roleId' => 'nullable|integer|min:1|exists:roles,id',
            'language' => ['required', new Enum(LanguagesEnum::class)],
            'settings' => 'required',
            'settings.canPrintGift' => 'nullable|boolean',
            'settings.canPrintSlip' => 'nullable|boolean'
        ];
    }

    public function messages()
    {
        return [
            'language.Illuminate\Validation\Rules\Enum' => "Valid language codes are `AR` and `EN`"
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'language' => strtolower($this->language)
        ]);
    }
}
