<?php

namespace Modules\Authentication\Repositories\Api\UserApp;

use DB;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\User\Entities\User;
use Modules\Core\Packages\SMS\SmsGetWay;
use Modules\User\Entities\PasswordReset;

class AuthenticationRepository
{
    public function __construct(User $user, PasswordReset $password, SmsGetWay $sms)
    {
        $this->password  = $password;
        $this->user      = $user;
        $this->sms       = $sms;
    }

    public function register($request)
    {
        DB::beginTransaction();

        $have_sms = config("app.have_sms");

        try {
            $image = $request['image'] ? getPathFileInStroage($request, "image", "users") : "/uploads/users/user.png";
            $user = $this->user->create([
                'name'          => $request['name'],
                'email'         => $request['email'],
                "phone_code"    => $request->phone_code,
                'mobile'        => $request['mobile'],
                "type"          => "user",
                "is_verified"   => $have_sms ? false : true,
                "firebase_uuid" => $request->firebase_uuid,
                "code_verified" => $have_sms ?  generateRandomCode(5) : null,
                'password'      => $request->password ? Hash::make($request['password']) : "",
                'image'         => $image,
                 "setting"      => [
                     "lang" => locale()
                 ]
            ]);

            
          
           
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function findUserByEmail($request)
    {
        $user = $this->user->where('email', $request->email)->first();
        return $user;
    }

    

    


    public function createToken($request)
    {
        $user = $this->findUserByEmail($request);

        $this->deleteTokens($user);

        $newToken = strtolower(Str::random(64));

       


        $token =  $this->password->updateOrCreate(['email'       => $user->email], [
          'email'       => $user->email,
          'token'       => $newToken,
          'created_at'  => Carbon::now(),
        ]);

        $data = [
          'token' => $newToken,
          'user'  => $user
        ];

        return $data;
    }

    public function resetPassword($request)
    {
        $user = $this->findUserByEmail($request);

        $user->update([
          'password' => Hash::make($request->password)
        ]);

        $this->deleteTokens($user);

        return true;
    }

    public function deleteTokens($user)
    {
        $this->password->where('email', $user->email)->delete();
    }

    public function findUser($mobile, $phone_code)
    {
        return  $this->user->where(
            [
            'mobile'       => $mobile,
            'phone_code'   => $phone_code
          ]
        )->firstOrFail();
    }

    public function resendCode($user)
    {
        $user->update([
            "code_verified" =>generateRandomCode(5)
        ]);

        return $this->sendSms($user);
    }

    public function resetDevciceToken($user)
    {
        $user->deviceTokens()->update([
            "user_id"=> null
        ]);
    }

    public function sendSms($user)
    {
        if (config("services.sms.test")) {
            return true;
        }
        $result =  $this->sms->send($user->code_verified, $user->getPhone());
        return $result["Result"] == "true";
    }
}
