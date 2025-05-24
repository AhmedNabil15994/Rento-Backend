<?php

namespace Modules\QSale\Http\Controllers\Api;

use Illuminate\Http\Request;

use Modules\QSale\Enum\AdsStatus;
use Modules\QSale\Http\Requests\Api\AdsRequest;
use Modules\QSale\Transformers\Api\AdsResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\QSale\Http\Requests\Api\AdsUpdateRequest;
use Modules\QSale\Http\Requests\Api\CompliantRequest;
use Modules\QSale\Repositories\Api\AdsRepository as Repo;

class AdsController extends ApiController
{
    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
    }

    public function store(AdsRequest $request)
    {
        $ads =  $this->repo->store($request);
        $ads->load(["subscription","addations", "media", "address"]);
        
        return $this->response(
            new AdsResource($ads)
        );
    }

    public function current(Request $request)
    {
        $ads =  $this->repo->getCurrentForUser($request);
        return $this->response(
            $ads? new AdsResource($ads) : null
        );
    }

    public function index(Request $request)
    {
        $with = ["user", "media", "addations", "attributes", "category","office","country", "address" /*"city", "state"*/];
        $ads =  $this->repo->listActive($request, $with);
        return $this->responsePagnation(
            AdsResource::collection($ads)
        );
    }


    public function update(AdsUpdateRequest $request, $id)
    {
        $ads =  $this->repo->update($request, $id);
        $ads->load(["subscription","addations", "media"]);
        return $this->response(
            new AdsResource($ads)
        );
    }

    public function updateAfterCreate(AdsUpdateRequest $request, $id)
    {
        $ads = $this->repo->findByAuthAndId($id);
        if ($ads->status != AdsStatus::WAIT && !$ads->checkIsPublish()) {
            return $this->error(__("qsale::api.ads.not_not_allow_edit"));
        }

        $ads =  $this->repo->updateAfterCreate($request, $ads);

        $ads->load(["subscription","addations", "media"]);
        return $this->response(
            new AdsResource($ads)
        );
    }


    public function delete(Request $request, $id)
    {
        $ads =  $this->repo->findByAuthAndId($id, ["user.currentSubscription", "media"]);
        $this->repo->delete($ads);
        return $this->response([]);
    }

    public function confirm(Request $request, $id)
    {
        $ads      =  $this->repo->findByAuthAndId($id, ["user.currentSubscription"]);
        if ($ads->is_paid || $ads->status != AdsStatus::WAIT) {
            return $this->error(__("qsale::api.ads.not_allow_payment"));
        }
        $payment = $this->repo->paymentHandler($ads);
        return $this->response([
            "ads"       => new AdsResource($ads),
            "url"       => $payment ? $this->repo->getUrlPayment($payment) : "",
        ]);
    }

    public function adsMe(Request $request)
    {
        $with = ["user", "media", "addations", "attributes", "category","office","country", "address" /*"city", "state"*/];

        $ads = $this->repo->listAdsMe($request, $with);
        return $this->responsePagnation(
            AdsResource::collection($ads)
        );
    }

    public function show(Request $request, $id)
    {
        $with = ["user", "media", "addations", "attributes", "category","office","address",/*"country", "city", "state"*/];
        $ads =  $this->repo->findById($id, $with);
        return $this->response(
            new AdsResource($ads)
        );
    }

    public function realated(Request $request, $id)
    {
        $with = ["user", "media", "addations", "attributes", "category","office","address",/*"country", "city", "state"*/];
        $ads =  $this->repo->findById($id, ["category"]);
        $reslated = $this->repo->getRealted($ads, $with);
        return $this->response(
            AdsResource::collection($reslated)
        );
    }

    public function createCompliant(CompliantRequest $request, $id)
    {
        $ads =  $this->repo->findById($id);
        $compiant = $this->repo->createComplaient($ads, $request);
        return $this->response(
            []
        );
    }

    public function incrementView($id)
    {
        $ads =  $this->repo->findById($id);
        $view = $this->repo->incrementView($ads);
        return $this->response(
            ["view"=> $ads->view]
        );
    }
}
