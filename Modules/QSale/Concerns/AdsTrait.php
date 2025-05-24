<?php
namespace Modules\QSale\Concerns;

use Modules\QSale\Enum\AdsType;
use Modules\QSale\Enum\AdsStatus;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;

/**
 * Ads function  and scope
 */
trait AdsTrait
{
    public function checkIsPublish()
    {
        $now = now()->format("Y-m-d");
        $inDate = ($now >= $this->start_at && $now <= $this->end_at);
        return in_array($this->status, [AdsStatus::PUBLIUSH,AdsStatus::CONFIRM ]) && $inDate;
    }

    public function checkIsNotExpired()
    {
        $now = now()->format("Y-m-d");
        return $now > $this->end_at;
    }

    public function scopeAuthTenant($query)
    {
        $query->where("user_id", auth()->id());
    }

    public function removeAddation($addation)
    {
        $this->update([
             "addation_total" => $this->addation_total - $addation->price,
             "total"          => $this->total - $addation->price
         ]);
        $addation->delete();
    }

    public function handleUserSubscription(&$user)
    {
        if ($this->type ==  AdsType::FREE) {
            $user->increment("number_of_free");
            return $user;
        }

        if ($this->type == AdsType::SUBSCRIPTION && $user->currentSubscription) {
            $user->currentSubscription->increment("current_use");
            return $user;
        }
    }

    public function handleUndoUserSubscription(&$user)
    {
        if ($this->type ==  AdsType::FREE) {
            $user->decrement("number_of_free");
            return $user;
        }
        
        if ($this->type == AdsType::SUBSCRIPTION && $user->currentSubscription) {
            $user->currentSubscription->decrement("current_use");
            return $user;
        }
    }

    public function confirm()
    {
        $now = now();
        $this->update([
            "is_paid"   => true ,
            "status"    => AdsStatus::PUBLIUSH,
            "published_at"=> now(),
            "start_at"  => $now,
            "end_at"    => $now->copy()->addDays($this->duration)   ,
        ]);
    }

    public function scopeAllowShow($query)
    {
        $query
             ->where("ads.status", AdsStatus::PUBLIUSH)
             ->where("ads.is_paid", true)
             ->whereHas("user", fn ($user) => $user->where("users.is_active", 1))
             ->where('ads.start_at', '<=', date('Y-m-d'))
             ->where('ads.end_at', '>=', date('Y-m-d'))
            ;
    }

    public function scopeSearchBase($query, $request)
    {
        $query->where(function ($query) use (&$request) {
            //  for key word search
            $query->when($request->search, function ($search) use (&$request) {

                // make it isolation
                $search->where(function ($search) use (&$request) {
                    $search->where("title", 'like', '%'. $request->input('search') .'%')
                            ->orWhere("description", 'like', '%'. $request->input('search') .'%')
                            ->orWhereHas("category.translations", function ($category) use (&$request) {
                                $category
                                        ->where('title', 'like', '%'. $request->input('search') .'%');
                            });
                });
            });

            // for office id
            $query->when($request->office_id, function ($base) use (&$request) {
                $base->where("office_id", $request->office_id);
            });

            // for user id
            $query->when($request->user_id, function ($base) use (&$request) {
                $base->where("user_id", $request->user_id);
            });

            // for country id
            $query->when($request->country_id, function ($base) use (&$request) {
                $base->where("country_id", $request->country_id);
            });

            // for city id
            $query->when($request->city_id, function ($base) use (&$request) {
                $base->where("city_id", $request->city_id);
            });

            // for state id
            $query->when($request->state_id, function ($base) use (&$request) {
                $base->where("state_id", $request->state_id);
            });

            // for subscription id
            $query->when($request->subscription_id, function ($base) use (&$request) {
                $base->where("subscription_id", $request->subscription_id);
            });

            // for addations id
            $query->when($request->addation_id, function ($base) use (&$request) {
                $base->whereHas("addations", fn ($addation) => $addation
                            ->where("addation_id", $request->addation_id));
            });
        });
    }

    public function scopeCategoryFilter($query, $request)
    {
        if ($request->category_id) {
            $query->where(function ($base) use (&$request) {
                $base->where("category_id", $request->category_id)
                     ->when($request->withChildCategory, function ($childQuery) use (&$request) {
                         $childIds =Category::active()->descendantsOf($request->category_id)
                        ->toFlatTree($request->category_id)->pluck("id")->toArray();
                         if (count($childIds) > 0) {
                             $childQuery->OrWhereIn("category_id", $childIds);
                         }
                     })  ;
            });
        }
        return $query;
    }

    public function scopeCategorySlugFilter($query, $request)
    {
        // if ($request->category) {
        //     $query->where(function ($base) use (&$request) {
        //         $base->
        //              whereHas("category.translations", function ($category) use (&$request) {
        //                  $category->where("slug", $request->category);
        //              })  ;
        //     });
        // }

        if ($request->category) {
            $category = Category::whereHas("translations", function ($category) use (&$request) {
                $category->where("slug", $request->category);
            })->first()  ;

           
            $childIds =Category::active()->descendantsAndSelf(optional($category)->id ?? -1)
                ->toFlatTree($request->category_id)->pluck("id")->toArray();
          
            $query->whereIn("category_id", $childIds);
        }
        return $query;
    }

    public function scopeAttributeFilter($query, $request)
    {
        if (is_array($request->attribute)) {
            // colpse the search attribute
            $query->where(function ($query) use (&$request) {
                foreach ($request->attribute as $attribute) {
                    $query->whereHas("attributes", function ($base) use (&$attribute) {
                        // $attribute = $request->attrbiute;
                        $base->when(isset($attribute["attribute_id"]), fn ($query) =>$query->where("attribute_id", $attribute["attribute_id"]))
                              ->when(isset($attribute["options_id"]) && is_array($attribute["options_id"]), fn ($query) =>$query->whereIn("option_id", $attribute["options_id"]))
                              ->when(isset($attribute["value"]) && $attribute["value"], fn ($query) =>$query->where("value", '=', $attribute["value"]))
                              ->when(isset($attribute["options_id"]) && is_numeric($attribute["options_id"]), fn ($query) =>$query->where("option_id", $attribute["options_id"]))
                            //   ->when(isset($attribute["value"]) && $attribute["value"] && !is_numeric($attribute["value"]), fn ($query) =>$query->where("value", 'like', '%'. $attribute["value"] .'%'))
                              ;
                    });
                }
            });
        }
        return $query;
    }

    public function scopeAddressFilter($query, $request)
    {
        if (is_array($request->address)) {
            // colpse the search attribute
            
            $query->where(function ($query) use (&$request) {
                $address = $request->address;
                $query->whereHas("address", function ($base) use (&$address) {
                    // $attribute = $request->attrbiute;
                    $base->when(isset($address["country_id"]), fn ($query) =>$query->where("ads_addresses.country_id", $address["country_id"]))
                              ->when(isset($address["state_id"]) && is_array($address["state_id"]), fn ($query) =>$query->whereIn("ads_addresses.state_id", $address["state_id"]))
                              ->when(isset($address["city_id"]), fn ($query) =>$query->where("ads_addresses.city_id", $address["city_id"]))
                              ->when(isset($address["state_id"]) && !is_array($address["state_id"]), fn ($query) =>$query->where("ads_addresses.state_id", $address["state_id"]));
                });
            });
        }
        return $query;
    }

    public function scopePriceFilter($query, $request)
    {
        if (is_array($request->price)) {
            $query->where(function ($base) use (&$request) {
                $price = $request->price;
                $base->when(
                    isset($price["min"]),
                    function ($ads) use (&$price) {
                        $ads->whereRaw("ads.price >= ?", $price["min"]);
                    }
                )
                      ->when(
                          isset($price["max"]),
                          function ($ads) use (&$price) {
                              $ads->whereRaw("ads.price <= ? ", $price["max"]);
                          }
                      )  ;
            });
        }
        
        return $query;
    }

    public function scopeIsFavourit($query, $user_id)
    {
        return $query->withCount([
            "userFavorites as is_favorite" => function ($query) use ($user_id) {
                $query->select(\DB::raw("count(favorites.ads_id) > 0 "))
                       ->whereRaw("users.id = ?", $user_id)
                       ;
            }
        ]);
    }


    public function scopeTypeAddationFilter($query, $request)
    {
        if ($request->type_addation) {
            $query->whereHas("addationsModel", function ($addation) use (&$request) {
                $addation->where("addations.type", $request->type_addation);
            });
        }
        if ($request->without_addation) {
            $query->doesntHave("addationsModel");
        }
    }

    public function scopeSortFilter($query, $request)
    {
        if ($request->sort_type_addation) {
            $query->sortBasedType($request->sort_type_addation);
        }
    }

    public function scopeSortBasedType($query, $type, $sort="DESC")
    {
        $query->withCount(["addationsModel as addations_sort"=>function ($addation) use ($type) {
            $addation->select(DB::raw("count(addations.id) > 0 "))
                  ->where("addations.type", $type);
        }]);
        $query->orderBy("addations_sort", $sort);
        ;
    }

    public function scopeWithIsType($query, $name="is_feature", $type="1")
    {
        $query->withCount(["addationsModel as $name"=>fn ($addation) =>
            $addation->select(DB::raw("count(addations.id) > 0 "))
                  ->where("addations.type", $type)
        ]);
    }



    public function checkIsType($type)
    {
        return $this->addationsModel->firstWhere("type", "=", $type);
    }
}
