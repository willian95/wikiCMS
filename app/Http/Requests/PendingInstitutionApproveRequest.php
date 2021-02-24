<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PendingInstitutionApproveRequest extends FormRequest
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
            "adminEmail" => "required|unique:users,email|email",
            "adminPassword" => "required|min:8",
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
            "adminEmail.unique" => "Administrator email is already in use",
            "adminPassword.required" => "Administrator password is required",
            "adminPassword.min" => "Administrator password have to be 8 character minimun",

        ];
    }
}
