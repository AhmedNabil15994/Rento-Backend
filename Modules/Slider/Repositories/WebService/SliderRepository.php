<?php

namespace Modules\Slider\Repositories\WebService;

use Modules\Slider\Entities\Slider;

 class SliderRepository
 {
     public function __construct(Slider $slider)
     {
         $this->slider   = $slider;
     }

     public function getRandomPerRequest($request)
     {
         $sliders = $this->slider
                ->active()->unexpired()->started()
                ->when($request->category_id, function ($query) use ($request) {
                    $query->whereHas("categories", fn ($q) => $q->where("categories.id", $request->category_id));
                })
                ->inRandomOrder()->take(6)->get();
         return $sliders;
     }
 }
