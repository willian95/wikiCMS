<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstitutionUpdateRequest extends FormRequest
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
            "name" => "required",
            "website" => "required",
            "type" => "required",
            "adminName" => "required",
            "adminEmail" => "required|email",
            "adminPassword" => "nullable|min:8",
            "adminName2" => "required",
            "adminEmail2" => "required|email",
            "adminPassword2" => "nullable|min:8",
        ];
    }

    public function messages()
    {
        return [

            "name.required" => "Name is required",
            "website.required" => "Website is required",
            "type.required" => "Type is required",

            "adminName.required" => "Administrator name is required",
            "adminEmail.required" => "Administrator email is required",
            "adminEmail.email" => "Administrator email is not valid",
            "adminPassword.required" => "Administrator password is required",
            "adminPassword.min" => "Administrator password have to be 8 character minimun",

            "adminName2.required" => "Administrator name is required",
            "adminEmail2.required" => "Administrator email is required",
            "adminEmail2.email" => "Administrator email is not valid",
            "adminPassword2.required" => "Administrator password is required",
            "adminPassword2.required" => "Administrator password is required",
            "adminPassword2.min" => "Administrator password have to be 8 character minimun",
        ];
    }
}
