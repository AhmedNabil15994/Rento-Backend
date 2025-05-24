<?php

namespace Modules\User\Transformers\Api;

use  Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\Api\OfficeResource;

class SelimUserResource extends JsonResource
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
           "office"        => new OfficeResource($this->whenLoaded("office")) 
       ];
    }
    
   
}
