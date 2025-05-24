<?php

namespace Modules\Offer\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Modules\Core\Traits\CasscadeAttach;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasTranslations,CasscadeAttach,
    SoftDeletes , ScopesTrait;

    public $translatable = ['title', "description"];
    protected $guarded 				    	= ['id'];
    protected $casscadeAttachs = ["image"];
    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id');
    }
}
