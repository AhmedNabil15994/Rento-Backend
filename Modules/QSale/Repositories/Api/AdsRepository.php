<?php

namespace Modules\QSale\Repositories\Api;

use DB;
use Hash;
use Modules\QSale\Enum\AdsType;
use Modules\QSale\Enum\AdsStatus;
use Modules\QSale\Entities\Addation;
use Modules\QSale\Entities\Ads  as Model;
use Modules\QSale\Concerns\AdsCreateTrait;
use Modules\Core\Packages\Payment\Contract\PaymentInterface;

class AdsRepository
{
    use AdsCreateTrait;

    public function __construct(Model $model, PaymentInterface $payment)
    {
        $this->model    = $model;
        $this->payment  = $payment;
    }

    public function findById($id, $with=[])
    {
        return $this->model->where("id", $id)->with($with)->firstOrFail();
    }

    public function findByAuthAndId($id, $with=[])
    {
        return $this->model
                    ->authTenant()
                    ->where("id", $id)
                    ->with($with)
                    ->firstOrFail();
    }
    public function listAdsMe($request, $with=["media"])
    {
        return $this->model->authTenant()
                    ->with($with)
                    ->where("ads.is_paid", true)
                    ->latest("id")
                    ->paginate($request->page_count ?? config("app.page_count", 15))
                    ;
    }

    public function listActive($request, $with=["media"])
    {
        // dd("hi");
        return $this->model
                    ->allowShow()
                    //  ->withIsType()
                    ->searchBase($request)
                    ->addressFilter($request)
                    ->categoryFilter($request)
                    ->attributeFilter($request)
                    ->priceFilter($request)
                    // ->isFavourit(20)
                   
                    ->typeAddationFilter($request)
                    ->sortFilter($request)
                    ->latest()
                    ->with($with)
                    ->paginate($request->page_count ?? config("app.page_count", 10));
    }


    public function getRealted(&$ads, $with=[])
    {
        $category = $ads->category;
        $sibilings = $category->siblings()->pluck("id")->toArray();
        $ids = array_merge($sibilings, [$category->id]);
        return  $this->model
        ->allowShow()
        ->with($with)
        ->where("id", "!=", $ads->id)
        ->whereIn("category_id", $ids)
        ->limit(6)->get();
    }

    public function createComplaient(&$ads, &$request)
    {
        return  $ads->complaints()->create($request->validated());
    }
  
    public function store(&$request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $user     = auth()->user();
            $user->load("office", "currentSubscription.package");
            $data     = array_merge($validated, $this->handelDataForAds($user, $request));
           
            $model = $this->updateOrCreateAds($data, $user, $request);

            if (!in_array($model->type, [AdsType::NORMAL])) {
                $model->handleUserSubscription($user);
            }

            $this->uploadAttach($model, $request, true);
            $this->handleOrUpdateAttribute($model, $request);
            $this->handleAddations($model, $request);
            $this->createAddress($model, $request);
            

            DB::commit();

           
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(&$request, &$id)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $model    = $this->findByAuthAndId($id);
            $model->update($data);
            $this->uploadAttach($model, $request);
            $this->deleteOldAtributeAndAddaionForUpdate($model, $request);
            $this->handleOrUpdateAttribute($model, $request);
            $this->handleAddations($model, $request);
            $this->deleteMediaInRequest($model, $request);
            $this->createAddress($model, $request);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateAfterCreate(&$request, &$model)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $model->attributes()->delete();
            $model->update($data);
            $this->uploadAttach($model, $request);
            $this->deleteMediaInRequest($model, $request);
            if (is_array($request->deleteAddress)) {
                $model->address()->whereIn("id", $request->deleteAddress)->delete();
            }
            if (is_array($request->addations) && count($request->addations)  > 0) {
                foreach ($addations as $addation) {
                    $model->removeAddation($addation);
                }
                $this->handleAddations($model, $request);
            }
            $this->createAddress($model, $request);
            $this->handleOrUpdateAttribute($model, $request);
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function delete(&$model)
    {
        DB::beginTransaction();

        try {
            $model->clearMediaCollection("default_image");
            $model->clearMediaCollection("attachs");
            if ($model->is_paid == false && $model->status == AdsStatus::WAIT) {
                $model->handleUndoUserSubscription($model->user);
            }
            $model->delete();

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function incrementView(&$model)
    {
        return $model->increment("view", 1);
    }

    
    
    


    public function getCurrentForUser($request)
    {
        return $this->model->authTenant()
                    ->where("status", AdsStatus::WAIT)
                    ->where("is_paid", false)
                    ->with([
                        "addations", "attributes", "country", "city" ,
                        "state"
                        ])
                    ->first();
    }
    


    public function uploadAttach(&$model, $request, $is_create=false)
    {
        if ($request->image) {
            $model->clearMediaCollection("default_image");
            $model->addMediaFromRequest("image")->toMediaCollection('default_image');
        }
        // if (!$request->image && $is_create) {
        //     $model->addMedia(public_path("/uploads/default.png"))->toMediaCollection('default_image');
        // }
        if (is_array($request->attachs)) {
            foreach ($request->attachs as $attach) {
                # code...
                $model->addMedia($attach)->toMediaCollection('attachs');
            }
        }
    }


    public function handelDataForAds(&$user, $request)
    {
        $number_of_free = setting("other", "number_of_free") ?? 0;
        $data  = [
            "duration"      => 0,
            "office_id"     => optional($user->office)->id,
            "user_id"       => $user->id,
            "is_paid"       => false,
            "type"          => AdsType::NORMAL ,
            "addation_total"=> 0,
            "ads_price"     => 0,
            "total"         => 0,
            "subscription_id"=> null,
        ];

        // First chekc if the allow free;
        // if ($user->number_of_free < $number_of_free) {
        //     $data["type"]       = AdsType::FREE;
        //     $data["duration"]   = setting("other", "default_duration") ?? 3;
        // } else {  // Handle normal or office

        if ( //Check if user is office and currentSubscription is allow to use
                // $user->type == "office" &&
                $user->currentSubscription &&
                $user->currentSubscription->checkAllowUse()
                ) {
            $data["type"]               = AdsType::SUBSCRIPTION;
            $data["duration"]           =  $user->currentSubscription->duration_of_ads;
            $data["subscription_id"]    = $user->currentSubscription->id;
        } else {
            $data["duration"]   = setting("other", "default_duration") ?? 3;
            $data["ads_price"]  = setting("other", "defult_price") ?? 3;
            $data["total"]      = $data["ads_price"];
        }
        // }


        return $data;
    }

    public function handleOrUpdateAttribute(&$model, &$request)
    {
        if (is_array($request->adsAttributes)) {
            foreach ($request->adsAttributes as $attribute) {
                $attribute["option_id"] = $attribute["option_id"] ??   $attribute["optional_id"] ?? null;
                $x =$model->attributes()
                        ->updateOrCreate(
                            [
                                    "ads_id"=>$model->id,
                                    "attribute_id"=> optional($attribute)["attribute_id"]
                                ],
                            $attribute
                        );
            }
        }
    
        return $model;
    }

    public function handleAddations(&$model, &$request)
    {
        if (is_array($request->addations)) {
            $addations = Addation::active()
                            ->whereIn("id", $request->addations)->get();
            $total = 0;
            foreach ($addations as $addation) {
                $total +=  $addation->price;
                $model->addations()->create([
                "addation_id"  => $addation->id ,
                 "price"       => $addation->price,
              ]);
            }
            $model->update(["addation_total" =>$total, "total"=> $model->total + $total]);
        };

        return $model;
    }

    public function updateOrCreateAds($data, &$user = null, $request)
    {
        $model = $this->model->where(
            [ "status"=>AdsStatus::WAIT, "is_paid"=> false ]
        )->first();

                  
        if ($model) {
            $model->handleUndoUserSubscription($user);
            $user->load( "currentSubscription.package");
            $data     = array_merge($data, $this->handelDataForAds($user, $request));
            $model->update($data);
            $model->clearMediaCollection("attachs");
            $model->attributes()->delete();
            $model->addations()->delete();
            $model->address()->delete();
        } else {
            $model = $this->model->create($data);
        }
      
        return $model;
    }

    public function deleteOldAtributeAndAddaionForUpdate(&$model, &$request)
    {
        //delete old attibutes
        $model->attributes()->delete();
        $model->address()->delete();
        $addations = $model->addations()->get();
        foreach ($addations as $addation) {
            $model->removeAddation($addation);
        }
    }

    public function deleteMediaInRequest(&$model, &$request)
    {
        if (is_array($request->deleteMedia)) {
            foreach ($request->deleteMedia as $idMedia) {
                # code...
                $model->deleteMedia($idMedia);
            }
        }
    }

    public function createAddress(&$model, &$request)
    {
        if (is_array($request->address)) {
            $country_id = config("customs.country_id");
            foreach ($request->address as $address) {
                $model->address()
                        ->updateOrCreate(
                            [
                                    "ads_id"=> $model->ads_id,
                                    "city_id"=> isset($address["city_id"]) ? $address["city_id"] : null,
                                    "state_id"=> isset($address["state_id"]) ?  $address["state_id"] : null,
                                    "country_id"=> $country_id
                                ]
                        );
            }
        }
    }
}
