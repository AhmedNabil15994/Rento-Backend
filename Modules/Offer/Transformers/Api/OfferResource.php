<?php

namespace Modules\Offer\Transformers\Api;

use  Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
      
        return [
            "id"         => $this->id,
            "image"      => url($this->image),
            "title"      => $this->title,
            "phone_number"=> $this->phone_number ?? "",
            "phone_whatsapp"=> $this->phone_whatsapp ?? "",
            "description"   => $this->when($request->with_desc || $request->is("api/offers/*"), htmlView($this->description)) ,
            "percent"    => $this->percent,
            "created_at" => $this->created_at->format("d-m-Y h:i a") ,
            
        ];
    }
}
