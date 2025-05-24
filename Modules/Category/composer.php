<?php

// Dashboard ViewComposr
view()->composer([
  'category::dashboard.categories.*',
  'worker::dashboard.workers.*',
  'user::dashboard.users.*',
  'vendor::dashboard.vendors.*',
  "qsale::dashboard.ads.*",
  "offer::dashboard.create",
  "offer::dashboard.edit",
  "slider::dashboard.create",
  "slider::dashboard.edit",
  "setting::dashboard.index"
 
], \Modules\Category\ViewComposers\Dashboard\CategoryComposer::class);

view()->composer([
  'apps::dashboard.index',
], \Modules\Category\ViewComposers\Dashboard\CountCategoryComposer::class);

view()->composer([
  'advertising::dashboard.advertising.*',
], \Modules\Category\ViewComposers\Dashboard\CategoryAllComposer::class);



view()->composer([
  'vendor::vendor.offers.*',
], \Modules\Category\ViewComposers\Vendor\CategoryComposer::class);


view()->composer([
  'apps::frontend.layouts.*' ,
  "apps::frontend.index", "qsale::frontend.index" ,
  "user::frontend.create-ads" ,
  "user::frontend.edit-ads"
], \Modules\Category\ViewComposers\FrontEnd\CategoryComposer::class);
