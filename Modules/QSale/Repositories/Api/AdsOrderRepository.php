<?php

namespace Modules\QSale\Repositories\Api;

use DB;
use Hash;
use Modules\QSale\Entities\Addation;
use Modules\QSale\Entities\AdsOrder  as Model;
use Modules\Core\Packages\Payment\Contract\PaymentInterface;

class AdsOrderRepository
{
    public function __construct(Model $model, PaymentInterface $payment)
    {
        $this->model   = $model;
        $this->payment  = $payment;
    }

    


    public function create(&$ads, &$request)
    {
        // dd($ads);
        DB::beginTransaction();
        try {
            $adsOrders = $ads->adsOrders()->updateOrCreate(
                ["user_id"=>auth()->id(),"ads_id"=>$ads->id],
                ["user_id"=>auth()->id()]
            );

            if (!$adsOrders->wasRecentlyCreated) {
                $adsOrders->addations()->delete();
            }

            $this->handleAddations($adsOrders, $request);
            DB::commit();
            return $adsOrders;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
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
            $model->update(["total"=> $total]);
        };

        return $model;
    }

    public function paymentHandler(&$model)
    {
        DB::beginTransaction();
        try {
            $payment= null;
            if ($model->total > 0) {
                $payment = $model->payment()->updateOrCreate([
                    "status" => "wait"
                ], [
                    "owner"=> auth()->user() ,
                    "total" => $model->total ,
                    "user_id"=> auth()->id(),
                ]);
            } else {
                $model->confirm();
            }

            DB::commit();
            return $payment;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function getUrlPayment(&$payment)
    {
        $payment->loadMissing("user");
        
        if ($payment) {
            return $this->payment->getResultForPayment($payment);
        }
        return "";
    }
}
