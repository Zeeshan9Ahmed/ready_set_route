<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class resetForgotPasswordRequest extends FormRequest
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
            "otp" => "required",
            "new_password" => "required|min:6",
            "email" => "required|email",
        ];
    }
}
