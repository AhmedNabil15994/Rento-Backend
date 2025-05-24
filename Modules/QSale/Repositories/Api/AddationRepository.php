<?php

namespace Modules\QSale\Repositories\Api;

use DB;
use Hash;
use Modules\QSale\Entities\Ads;
use Modules\QSale\Enum\AddationType;
use Modules\QSale\Entities\Addation  as Model;

class AddationRepository
{
    public function __construct(Model $model)
    {
        $this->model   = $model;
    }

  


    public function getAll(&$request , $order = 'id', $sort = 'asc')
    {
        $models = $this->model->active()->orderBy($order, $sort)
                      ->when($request->type, function($query) use($request){
                            $query->where("type", $request->type );
                      })  
                     ->get();
        return $models;
    }

    public function getForHome($type = 1, $order = 'id', $sort = 'asc')
    {
        $models = $this->model->active()
                     ->orderBy($order, $sort)
                     ->where("type", $type)
                     ->get();
        return $models;
    }


    public function findById($id, $with=[])
    {
        $model = $this->model->with($with)->findOrFail($id);
        return $model;
    }

    public function listAds(&$model, &$request, $with=[])
    {
        return $model->ads()
                    ->allowShow()
                    ->searchBase($request)
                    ->categoryFilter($request)
                    ->attributeFilter($request)
                    ->priceFilter($request)
                    ->latest()
                    ->paginate($request->page_count ?? config("app.page_count", 15));
    }

    public function listAdsBasedType($request, $with){
        $type  = $request->type ?? AddationType::NORMAL;
        $query = Ads::allowShow() 
                    ->whereHas("addationsModel",fn($addation)=> $addation->where("addations.type", $type))  
                    ->categoryFilter($request)
                    ->with($with)
                    ;
        if($request->list_type=="page"){
            return $query->paginate($request->page_count ?? config("app.page_count", 15));
        }
        return $query->inRandomOrder()->limit($request->page_count ?? 8)->get();
       
                    

    }

    


    


   
}
