<?php

namespace Modules\User\Repositories\Api;

use DB;
use File;
use Hash;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Packages\SMS\SmsGetWay;
use Modules\User\Entities\UserTransaction;
use Spatie\ResponseCache\Facades\ResponseCache;
use Modules\Transaction\Services\PaymentService;
use Modules\User\Notifications\UserReachToDeposit;

class UserRepository
{
    public function __construct(User $user, SmsGetWay $sms)
    {
        $this->user      = $user;
        $this->sms       = $sms;
    }

    public function update($request)
    {
        $user = auth()->user();
        $image = $user->image;
        if ($request->image) {
            deleteFileInStroage($user->image);
            $image = pathFileInStroage($request, "image", "users");
        }
        $firebase_uuid = $user->firebase_uuid;
        if ($request->firebase_uuid) {
            $firebase_uuid = $request->firebase_uuid;
        }

        $data = [
            'name'          => $request['name'],
            'email'         => $request['email'],
            'mobile'        => $request['mobile'],
            'phone_code'    => $request['phone_code'],
            "image"         => $image ,
            "firebase_uuid" => $firebase_uuid
        ];

        if (config("app.have_sms")) {
            
            if ($user->phone_code != $request['phone_code'] || $user->mobile != $request['mobile']) {
                $data = array_merge(
                    $data,
                    [
                            "is_verified" => false,
                            "code_verified" =>  generateRandomCode(5),
                        ]
                );
            }
        }
        
        

        DB::beginTransaction();
        try {
            $user->update($data);
            DB::commit();
            if ($user->is_verified == false && $user->code_verified) {
                $this->sms->send($user->code_verified, $user->getPhone());
            }
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function createOrUpdateOffice(&$request)
    {
        $user = auth()->user();
     
        $old = $user->office;
        $image = "/uploads/default.png";
        if ($request->image) {
            if ($old && $old->image) {
                deleteFileInStroage($old->image);
            }
            $image = pathFileInStroage($request, "image", "users/".$user->id);
        }
        $data = array_merge($request->validated(), ["image"=> $image]);
        

        DB::beginTransaction();
        try {
            $office = $user->office()->updateOrCreate(["user_id"=> $user->id], $data);
            if ($user->type != "office") {
                $user->update(["type"=>"office"]);
            }
            if(is_array($request->categories)){
                $office->categories()->sync($request->categories);
                ResponseCache::clear();
            }
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updatePassword(&$user, &$request)
    {
        try {
            $user->update([
                
                'password'      => bcrypt($request->new_password),
               
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
   

    public function userProfile($with= [])
    {
        return auth()->user()->load($with);
    }

    

    

    public function updateSetting(&$request)
    {
        DB::beginTransaction();
        $user = auth()->user();
        $setting = array_merge($user->setting ? $user->setting : ["lang"=>"ar"], $request->all());
        try {
            $user->update([
                'setting'      => $setting ,
            ]);
             
            if ($request->has("lang")) {
                $user->deviceTokens()->update([
                    "lang"=> $setting["lang"]
                ]);
            }
           

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
