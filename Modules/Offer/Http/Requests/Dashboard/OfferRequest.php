<?php

namespace Modules\Offer\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image'           => 'nullable|image',
            'title.*'         => 'required|max:255',
            'description.*'         => 'required',
            "start_at"        => "required|date",
            "end_at"          => "required|after_or_equal:".$this->start_at,
            "percent"         => "required_if:direct_percent,on|numeric|max:100|min:0" ,
            "category_id"     => "nullable|exists:categories,id"   ,
            "phone_number"    => "nullable|max:255",
            "phone_whatsapp"    => "nullable|max:255",
        ];
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
}
