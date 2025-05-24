<?php

namespace Modules\User\Entities;

use Modules\QSale\Entities\Ads;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Modules\Area\Entities\Country;
use Modules\Core\Traits\ScopesTrait;
use Modules\Core\Traits\CasscadeAttach;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Modules\QSale\Entities\Subscription;
use Modules\Core\Traits\ClearsResponseCache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\DeviceToken\Entities\DeviceToken;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Modules\Core\Filters\Search\SearchManager;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Translation\HasLocalePreference;

class User extends Authenticatable implements HasLocalePreference
{
    use Notifiable , ScopesTrait , HasApiTokens;
    use LaratrustUserTrait,  SearchManager;
    use  ClearsResponseCache;

    use CasscadeAttach;

    use SoftDeletes ;

    protected $dates = [
      'deleted_at'
    ];

    protected $with = [
    ];

 
    /**
    * The model's default values for attributes.
    *
    * @var array
    */
    protected $attributes = [
        'is_active' => 1,
    ];
  
    protected $fillable = [
        'name', 'email', 'password', 'mobile' , 'image' , 'phone_code', "type",
         "is_active", "code_verified","setting", "country_id","type" , "is_verified" ,"firebase_uuid"
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        "setting" => "array" ,
        "is_verified"=> "boolean"
    ];

    

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class, "user_id");
    }

    public function ads()
    {
        return $this->hasMany(\Modules\QSale\Entities\Ads::class, "user_id");
    }


    public function adsFavorites()
    {
        return $this->belongsToMany(Ads::class, "favorites", "user_id", "ads_id" )
                    ->withTimestamps();
    }

   
   

    
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function office()
    {
        return $this->hasOne(Office::class, 'user_id');
    }

    public function currentSubscription()
    {
        return $this->hasOne(Subscription::class, 'user_id')->where("is_default", true);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    public function scopeUser($query)
    {
        return $query->whereIn('type', ["user", "office"]);
    }

    public function scopeOfficeUser($query)
    {
        return $query->where('type', "office");
    }

    public function scopeAdminUser($query)
    {
        return $query->where('type', "admin");
    }

    

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

 
    
   

    public function preferredLocale()
    {
        return isset($this->setting["lang"]) ? $this->setting["lang"] :locale();
    }

    public function getPhone(){
        return $this->phone_code . $this->mobile;
    }

   

    public function scopeSearchFilter($query, &$request)
    {
    }

    public function scopeVendorWorker($query)
    {
        return $query
                    ->whereHas("workerProfile",function ($workerProfile) {
                        $vendors = optional(auth()->user()->workerProfile)->vendor_id;
                        
                        $workerProfile->whereIn("vendor_id", $vendors ? [$vendors] : []);
                            
                    });
    }


}
