<?php

namespace Modules\QSale\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule=  [
            "title"       => "required|max:255",
            "description" => "nullable",
            "mobile"      => "nullable|numeric",
            "hide_private_number"=> "required|boolean",
            "price"             => "nullable|numeric|min:0|regex:/^\d{1,13}(\.\d{1,4})?$/",
            "image"             => "nullable|image",
            "attachs"           => "nullable|array",
            "attachs.*"         => "file",
            "category_id"       => "required|exists:categories,id" ,
            // "country_id"    => ["nullable", "exists:countries,id"]  ,
            // "city_id"       => ["nullable",Rule::exists("cities", "id")->where(function($query){
            //     $query->where("country_id", $this->country_id);
            //  }) ],
            //  "state_id"       => ["nullable",Rule::exists("states", "id")->where(function($query){
            //     $query->where("city_id", $this->city_id);
            //  }) ],
             "address"              => "nullable|array",
             "address.*.country_id" => "nullable|exists:countries,id",
             "address.*.city_id"    => "required|exists:cities,id"    ,
             "address.*.state_id"   => "nullable|exists:states,id"    ,
        ];
        

        return array_merge(
            $rule,
            $this->validationAttraibute(),
            $this->validationAddations(),
            $this->validationAddress(),
        );
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function validationAttraibute()
    {
        return [
            "adsAttributes.*"               => "nullable|array" ,
            "adsAttributes.*.attribute_id"    => ["sometimes",
                                                        Rule::exists("category_attributes", "attribute_id")
                                                            ->where("category_id", $this->category_id)
                                                 ],
            "adsAttributes.*.option_id"       => ["sometimes",
                                                    "nullable",
                                                        Rule::exists("options", "id")
                                                            ->where("attribute_id", $this->input("adsAttributes.*.attribute_id"))
                                                ] ,
            "adsAttributes.*.optional_id"       => ["sometimes",
                "nullable",
                    Rule::exists("options", "id")
                        ->where("attribute_id", $this->input("adsAttributes.*.attribute_id"))
            ] ,
            "adsAttributes.*.value"           => "sometimes"
        ];
    }

    public function validationAddations()
    {
        return [
            "addations.*"               => "nullable|exists:addations,id" ,
        ];
    }

    public function validationAddress()
    {
        return [
            "address"                         => "required|array|min:0"  ,
            "address.*.city_id"               => "nullable|exists:cities,id" ,
            "address.*.state_id"              => "nullable|exists:states,id" ,
        ];
    }
}
