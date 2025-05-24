<?php

namespace Modules\Offer\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Offer\Transformers\Api\OfferResource;

use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Offer\Repositories\Api\OfferRepository as Repo;


class OfferController extends ApiController
{
    function __construct(Repo $repo)
    {
        
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $users =  $this->repo->getAll($request);
        return $this->responsePagnation(
            OfferResource::collection($users)
        );
    }

    public function view(Request $request, $id)
    {
        $package  =  $this->repo->findById($id);
    
        return $this->response(
            new OfferResource($package)
        );
        
    }

   



    
}
