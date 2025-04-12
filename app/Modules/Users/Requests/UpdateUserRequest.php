<?php

namespace App\Modules\Users\Requests;

use App\Modules\Shared\Enums\LanguagesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'userId' => 'required|integer|min:1|exists:users,id',
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,$this->userId",
            'fulfillmentCenterId' => 'required|integer|min:1|exists:fulfillment_centers,id',
            'roleId' => 'nullable|integer|min:1|exists:roles,id',
            'language' => ['required', new Enum(LanguagesEnum::class)],
            'phone' => "required|string|unique:users,phone,$this->userId",
            'settings' => 'required',
            'settings.canPrintGift' => 'required|boolean',
            'settings.canPrintSlip' => 'required|boolean'
        ];
    }

    public function  prepareForValidation()
    {
        $this->merge([
            'userId' => (int) $this->route('userId'),
            'language' => strtolower($this->language)
        ]);
    }
}
