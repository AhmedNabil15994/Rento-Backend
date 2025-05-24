<?php

namespace Modules\Apps\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\QSale\Repositories\Dashboard\AdsRepository;
use Modules\User\Repositories\Dashboard\UserRepository;
use Modules\Offer\Repositories\Dashboard\OfferRepository;
use Modules\User\Repositories\Dashboard\OfficeRepository;
use Modules\QSale\Repositories\Dashboard\PackageRepository;
use Modules\QSale\Repositories\Dashboard\AddationRepository;
use Modules\Category\Repositories\Dashboard\CategoryRepository;
use Modules\Attribute\Repositories\Dashboard\AttributeRepository;

class DashboardController extends Controller
{
    public function index()
    {
        $userRepo = app()->make(UserRepository::class);
      
        $userCreated = $userRepo->userCreatedStatistics();
        $userData = $userRepo->getStatistics();
        
        $officeRepo = app(OfficeRepository::class);
        $officeData = $officeRepo->getStatistics();

        $addationRepo = app(AddationRepository::class);
        $addationData = $addationRepo->getStatistics();

        $adsRepo = app(AdsRepository::class);
        $adsData = $adsRepo->getStatistics();

        $categoryRepo = app(CategoryRepository::class);
        $categoryData = $categoryRepo->getStatistics();

        $attributeRepo = app(AttributeRepository::class);
        $attributeData = $attributeRepo->getStatistics();


        $packageRepo = app(PackageRepository::class);
        $packageData = $packageRepo->getStatistics();

        $offerRepo = app(OfferRepository::class);
        $offerData = $offerRepo->getStatistics();


      
        return view('apps::dashboard.index', compact(
            "userCreated",
            "userData" ,
            "officeData",
            "packageData" ,
            "addationData" ,
            "categoryData" ,
            "adsData"
        ))
        ;
    }
}
