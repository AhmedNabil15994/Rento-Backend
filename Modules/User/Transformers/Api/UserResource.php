<?php

namespace Modules\User\Transformers\Api;

use  Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\Api\OfficeResource;

class UserResource extends JsonResource
{
    
    public function toArray($request)
    {
       
        return [
           'id'            => $this->id,
           'name'          => $this->name ,
           'image'         => url($this->image),
           "email"         => $this->email ?? "",
           "phone_code"    => $this->phone_code,    
           'mobile'        => $this->mobile,
           "is_active"     => $this->is_active ? 1 : 0, 
           "type"          => $this->type,     
           "number_of_free"=> $this->number_of_free,    
           "is_verified"   => $this->is_verified  ,
           "office"        => new OfficeResource($this->whenLoaded("office")) ,
           "firebase_uuid" => $this->firebase_uuid,
    
       ];
    }
    
   
}
