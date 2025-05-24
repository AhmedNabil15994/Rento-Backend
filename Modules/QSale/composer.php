<?php

view()->composer([
    "user::dashboard.users.*"
  
 ], \Modules\QSale\ViewComposers\Dashboard\PackageComposer::class);

 view()->composer([
    "qsale::dashboard.ads.create", "qsale::dashboard.ads.edit" ,
    "user::frontend.create-ads"
  
 ], \Modules\QSale\ViewComposers\Dashboard\AddationsComposer::class);



 view()->composer([
   // "apps::frontend.layouts._footer"
 
   ], \Modules\QSale\ViewComposers\Frontend\AdsCountComposer::class);
