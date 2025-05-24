<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Hash;
use Modules\User\Transformers\Api\UserResource;
use Modules\User\Http\Requests\Api\OfficeRequest;
use Modules\User\Http\Requests\Api\ResetPassword;
use Modules\User\Transformers\Api\AddressResource;

use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\User\Http\Requests\Api\AddressStoreRequest;
use Modules\User\Http\Requests\Api\UpdateProfileRequest;
use Modules\User\Repositories\Api\UserRepository as Repo;
use Modules\User\Http\Requests\Api\UserSettingUpdateRequest;
use Modules\User\Transformers\Api\Notification\UserNotiifcationResource;
use Modules\User\Transformers\Api\Notification\UserNotiifcationCollection;

class UserController extends ApiController
{
    public function __construct(Repo $user)
    {
        $this->user = $user;
    }

   

    public function profile()
    {
        $user =  $this->user->userProfile(["office.categories"]);
       
        return $this->response(new UserResource($user));
    }    

    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->user->update($request);

        $user =  $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function getVerifidCode(Request $request)
    {
        $user = User::where("phone_code", $request->phone_code)
               ->where("mobile", $request->mobile)->first(); 
        
        return $this->response(["code"=> optional($user)->code_verified ?? ""]);
    }

    public function updateOrCreateOffice(OfficeRequest $request){
       
    
        $user = $this->user->createOrUpdateOffice($request);
        $user->load(["office.country", "office.city", "office.state", "office.categories"]);
        return $this->response(new UserResource($user));
    }

    public function resetPassword(ResetPassword $request)
    {
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return $this->invalidData(["current_password"=>__("user::api.users.validation.password.not_correct")]);
        }
        $this->user->updatePassword($user, $request);
        return $this->response([]);
    }

    public function updateSetting(UserSettingUpdateRequest $request)
    {
        $this->user->updateSetting($request);
        return $this->response([]);
    }

   
    public function testFcm(Request $request)
    {
    }


   
    public function notifications(Request $request)
    {
        $notifications = auth()->user()->notifications()->latest()->
                        paginate($request->page_count ?? config("app.page_count", 15));
        return $this->responsePagnation(
            new UserNotiifcationCollection($notifications)
        );
    }
}
