<?php

namespace Modules\User\Repositories\Dashboard;

use DB;
use Hash;
use Modules\User\Entities\User;
use Modules\QSale\Entities\Package;
use Spatie\ResponseCache\Facades\ResponseCache;
use Modules\User\Notifications\UserStatusChange;

class UserRepository
{
    public function __construct(User $user)
    {
        $this->user      = $user;
    }


    public function userCreatedStatistics()
    {
        $data["userDate"] = $this->user
                            ->user()
                            ->select(\DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date"))
                            ->groupBy('date')
                            ->pluck('date');

        $userCounter = $this->user
                        ->user()
                        ->select(\DB::raw("count(id) as countDate"))
                        ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                        ->get();



        $data["countDate"] = json_encode($userCounter->pluck("countDate")->toArray());

        return $data;
    }

    public function getStatistics()
    {
        $count  =$this->user->user()->count();
        return ["count" => $count];
    }

    public function countUsers($order = 'id', $sort = 'desc')
    {
        $users = $this->user->user()->count();

        return $users;
    }

    /*
    * Get All Normal Users Without Roles
    */
    public function getAllUsers($order = 'id', $sort = 'desc')
    {
        $users = $this->user->user()->select("id,name")->orderBy($order, $sort)->get();
        return $users;
    }

    /*
    * Get All Normal Users Without Roles
    */
    public function getAllUsersActive($order = 'id', $sort = 'desc')
    {
        $users = $this->user->user()->active()->orderBy($order, $sort)->select("id", "name", "type")->get();
        return $users;
    }

    /*
    * Find Object By ID
    */
    public function findById($id, $with=[])
    {
        $user = $this->user->withDeleted()->with($with)->findOrFail($id);
        return $user;
    }

    /*
    * Find Object By ID
    */
    public function findByEmail($email)
    {
        $user = $this->user->where('email', $email)->first();
        return $user;
    }


    /*
    * Create New Object & Insert to DB
    */
    public function create($request)
    {
        DB::beginTransaction();

        try {
            $image = $request['image'] ? pathFileInStroage($request, "image", "users") : "/uploads/users/user.png";

            $model = $this->user->create([
              'name'          => $request['name'],
              "phone_code"    => $request->phone_code,
              "type"          => $request->type,
              "is_active"     => $request->is_active == "on" ? 1 : 0,
              "is_verified"     => $request->is_active == "on" ? 1 : 0,
              'email'         => $request['email'],
              'phone_code'    => $request['phone_code'],
              'mobile'        => $request['mobile'],
              'image'         => $image,

          ]);
            if ($request->type != "user" && $request->office) {
                $this->saveOfficeData($model, $request);
            }
            if($request->input("office.package_id")) {
                $this->createSubscription($model, $request);
            }

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    /*
    * Find Object By ID & Update to DB
    */
    public function update($request, $id)
    {
        DB::beginTransaction();

        $user = $this->findById($id, ["office", "currentSubscription"]);
        $restore = $request->restore ? $this->restoreSoftDelte($user) : null;

        try {
            $image =  $user->image;
            $copy  = $user->replicate();

            if ($request->image) {
                deleteFileInStroage($user->image);
                $image = pathFileInStroage($request, "image", "users");
            }



            if ($request['password'] == null) {
                $password = $user['password'];
            } else {
                $password  = Hash::make($request['password']);
            }

            $user->update([
                'name'          => $request['name'],
                "phone_code"    => $request->phone_code,
                "type"          => $request->type,
                "is_active"     => $request->is_active == "on" ? 1 : 0,
                "is_verified"   => $request->is_verified == "on" ? 1 : 0,
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'image'         => $image,
                'password'      => $password,
                'image'         => $image,
            ]);

            if ($copy->type != "user") {
                if ($user->type == "user") {
                    if ($user->office) {
                        $user->office->delete();
                    }
                // if ($user->currentSubscription) {
                    //     $user->currentSubscription->update(["is_default"=> false]);
                // }
                } else {
                    $this->saveOfficeData($user, $request, true);
                }
            } else {
                if ($request->type != "user" && $request->office) {
                    $this->saveOfficeData($user, $request);
                }
            }

            if($request->input("office.package_id") && !$user->currentSubscription) {
                $this->createSubscription($user, $request);
            }
            // subscription
            if (optional($user->currentSubscription)->package_id != $request->input("office.package_id")) {
                $user->subscriptions()->update(["is_default"=> false]);
                $this->createSubscription($user, $request);
            } elseif (optional($user->currentSubscription)->package_id == $request->input("office.package_id")) {
                $this->updateDefaultSubscription($user, $request);
            }


            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model->trashed()):
                deleteFileInStroage($model->image);
                $model->forceDelete();
                else:
                    $model->delete();


                endif;

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function renwal(&$user)
    {
        DB::beginTransaction();
        $package = $user->currentSubscription->package;
        $date = now();
        try {
            $data = [
                "current_use"     => 0,
                "is_default"      =>true ,
                "start_at"        => $date ,
                "end_at"          => $date->copy()->addDays($package->duration),
                "money"           => $package->price,
                "max_use"         => $package->number_of_ads,
                "duration_of_ads" => $package->duration_of_ads,
                "renewal_count"   => $user->currentSubscription->renewal_count +1,
                "renewal_at"      => $date

            ];

            $user->currentSubscription->update($data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Find all Objects By IDs & Delete it from DB
    */
    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Generate Datatable
    */
    public function QueryTable($request)
    {
        $query = $this->user->withDeleted()->where('id', '!=', auth()->id())->user()->where(function ($query) use ($request) {
            $query->where('id', 'like', '%'. $request->input('search.value') .'%');
            $query->orWhere('name', 'like', '%'. $request->input('search.value') .'%');
            $query->orWhere('email', 'like', '%'. $request->input('search.value') .'%');
            $query->orWhere('mobile', 'like', '%'. $request->input('search.value') .'%');
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    /*
    * Filteration for Datatable
    */
    public function filterDataTable($query, $request)
    {
        // Search Users by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }
        if (isset($request['req']['status']) &&  $request['req']['status'] != '') {
            $query->where("is_active", $request['req']['status']);
        }

        if (isset($request['req']['type']) &&  $request['req']['type'] != '') {
            $query->where("type", $request['req']['type']);
        }




        return $query;
    }

    public function sendNotifcationStatusChange(&$user, $type)
    {
        $user->notify(new UserStatusChange($type));
    }


    public function saveOfficeData(&$model, &$request, $update= false)
    {
        if ($request->office) {
            $image = "/uploads/default.png";

            if ($update) {
                $office = $model->office ;
                if ($request->has("office.image")) {
                    if ($office) {
                        deleteFileInStroage($office->image);
                    }
                } else {
                    $image = $office ? $office->image : $image;
                }
            }
            $image = $request->has("office.image") ? pathFileInStroage($request, "office.image", "users/".$model->id) : $image;
            // dd($image, $request->file("office.image"));/

            $data  = array_merge($request->office, [
                "image"   => $image,
                "status"  => $request->input("office.status")  == "on" ? 1 : 0
            ]) ;

            $office=  $model->office()->updateOrCreate(["user_id"=>$model->id], $data);
            if(is_array($request->input("office.categories"))) {
                $office->categories()->sync($request->input("office.categories"));
                ResponseCache::clear();
            }
        }
    }

    public function createSubscription(&$model, &$request)
    {
        $package = Package::findOrFail($request->input("office.package_id"));
        $subscription = $model->subscriptions()->updateOrCreate(
            ["user_id"=> $model->id, "package_id"=> $package->id],
            $this->handleDataPakcage($package, $request)
        );
        if (!$subscription->wasRecentlyCreated) {
            $subscription->update(["renewal_count"=> $subscription->renewal_count +1, "renewal_at"=>now()]);
        }
    }

    public function updateDefaultSubscription(&$model, &$request)
    {
        $package = Package::findOrFail($request->input("office.package_id"));
        $model->subscriptions()->updateOrCreate(["user_id"=> $model->id, "is_default"=> true], $this->handleDataPakcage($package, $request));
    }


    public function handleDataPakcage(&$package, &$request)
    {
        $date = now();
        $data = [
            "current_use"     => 0,
            "is_paied"        => true ,
            "is_free"         => $package->is_free,
            "is_default"      =>true ,
            "start_at"        => $date ,
            "end_at"          => $date->copy()->addDays($package->duration),
            "money"           => $package->price,
            "max_use"         => $package->number_of_ads,
            "duration_of_ads" => $package->duration_of_ads,
            "package_id"      => $package->id,

        ];

        if (!$request->use_pakcage_info  && is_array($request->subscription)) {
            $data = array_merge($data, $request->subscription);
        }
        // dd($data);

        return $data;
    }
}
