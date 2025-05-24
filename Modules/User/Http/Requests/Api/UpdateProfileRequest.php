<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            //handle updates
            case 'post':
            case 'POST':
                return [
                    'name'            => 'required',
                    "phone_code"      => "nullable",
                    'mobile'          => ['required_with:phone_code','numeric','digits_between:3,20',
                                        Rule::unique("users")->where(function ($query) {
                                            $query->where("mobile", $this->mobile)
                                            ->where("phone_code", $this->phone_code)
                                            ->where("id", "!=", auth()->id());
                                        })
                            ],
                    'email'           => 'nullable|unique:users,email,'.auth()->id().'',
                    "image"           => "nullable|image"  ,
                    "firebase_uuid"   => "sometimes|nullable|unique:users,firebase_uuid,".auth()->id(),
                    
                ];
        }
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'name.required'           => __('user::api.users.validation.name.required'),
            'email.required'          => __('user::api.users.validation.email.required'),
            'email.unique'            => __('user::api.users.validation.email.unique'),
            'mobile.required'         => __('user::api.users.validation.mobile.required'),
            'mobile.unique'           => __('user::api.users.validation.mobile.unique'),
            'mobile.numeric'          => __('user::api.users.validation.mobile.numeric'),
            'mobile.digits_between'   => __('user::api.users.validation.mobile.digits_between'),
            'password.required'       => __('user::api.users.validation.password.required'),
            'password.min'            => __('user::api.users.validation.password.min'),
            'password.same'           => __('user::api.users.validation.password.same'),
        ];

        return $v;
    }
}
