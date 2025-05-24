<?php

namespace Modules\QSale\Repositories\Api;

use DB;
use Hash;
use Modules\QSale\Entities\Package  as Model;

class PackageRepository
{
    public function __construct(Model $model)
    {
        $this->model   = $model;
    }

  


    public function getAll(&$request, $order = 'sort', $sort = 'asc')
    {
        $models = $this->model->active()
                     ->currentSubscription($request)
                     ->orderBy($order, $sort)
                     ->when($request->has("is_free"), fn ($q) =>$q->where("is_free", $request->is_free))
                     ;
       
        if ($request->type) {
            $models->where("type", $request->type);
        }
                    
        if (auth("api")->check()) {
            $user = auth("api")->user();
            if ($user->currentSubscription) {
                $models->where("first_time", false);
            }

            if ($request->ignore_free_subscription) {
                $packagesFree =   $user->subscriptions()
                      ->distinct("package_id")
                      ->whereHas("package", fn ($q) =>$q->where("packages.is_free", 1))
                      ->get("package_id")
                      ->pluck("package_id")
                      ->toArray()
                      ;
                if (count($packagesFree) > 0) {
                    $models->whereNotIn("id", $packagesFree);
                }
            }
        }
                    
        return $models->paginate($request->page_count ??  config("app.page_count", 15));
    }

   
    public function findById($id, $with=[])
    {
        $model = $this->model->with($with)->findOrFail($id);
        return $model;
    }
}
