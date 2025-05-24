<?php

return [
    'coupons'  => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'options'       => 'Options',
            'status'        => 'Status',
            "code"         => "Code" ,
            'min'              => 'Min value',
            'max'               => 'Max value when percent',
            "amount"            => "Discount" ,
            "expired_at"        => "expired at",
            "max_use"           => "Max use",
            "current_use"       => "Current use",
            "max_use_user"      => "Max use user",
            "is_fixed"          => "Is fixed" ,
           
          
        ],
        'form'      => [
            'status'        => 'Status',
            "code"         => "Code" ,
            'min'              => 'Min value',
            'max'               => 'Max value when percent',
            "amount"            => "Discount" ,
            "expired_at"        => "expired at",
            "max_use"           => "Max use",
            "current_use"       => "Current use",
            "max_use_user"      => "Max use user",
            "is_fixed"          => "Is fixed" ,
            'tabs'              => [
                'general'   => 'General Info.',
            ],
          
        ],
        'routes'    => [
            'create'    => 'Create Coupon',
            'index'     => ' Coupons ',
            'update'    => 'Edit Coupon',
        ],
        'validation'=> [
            "not_valid" => "Coupon No Valid"
        ],
    ],
    'packages'  => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'options'       => 'Options',
            'status'        => 'Status',
            "is_free"       => "Is free" ,
            "title"       => "Title" ,
            "description" => "Description",
            "price"     =>"Price" ,
            "duration"  =>"Duration" ,
            "number_of_ads" => "Number of ads",
            "number_of_image" => "Number of image",
            "duration_of_ads"  => "Duration of ads",
          
        ],
        'form'      => [
            'status'        => 'Status',
            "is_free"       => "Is free" ,
            "title"       => "Title" ,
            "description" => "Description",
            "price"     =>"Price" ,
            "duration"  =>"Duration" ,
            "number_of_ads" => "Number of ads",
            "number_of_image" => "Number of image",
            "first_time" => "First Time",
            "type"       => "Package Type",
            "types"      => [
                "user"      => "User" ,
                "office"    => "Office"
            ],
            "duration_of_ads"  => "Duration of ads",
            "sort"          => "sort ",
            'tabs'              => [
                'general'   => 'General Info.',
            ],
          
        ],
        'routes'    => [
            'create'    => 'Create Package',
            'update'     => 'Edit  Package',
            'index'    => 'packages',
        ],
       
    ],
    'republished_packages'  => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'options'       => 'Options',
            'status'        => 'Status',
            "is_free"       => "Is free" ,
            "title"       => "Title" ,
            "description" => "Description",
            "price"     =>"Price" ,
            "duration"  =>"Duration" ,
           
          
        ],
        'form'      => [    
            'status'        => 'Status',
            "is_free"       => "Is free" ,
            "title"       => "Title" ,
            "description" => "Description",
            "price"     =>"Price" ,
            "duration"  =>"Duration" ,
            'tabs'              => [
                'general'   => 'General Info.',
            ],
          
        ],
        'routes'    => [
            'create'    => 'Create Republished Package',
            'update'     => 'Edit  Republished Package',
            'index'    => 'Republished packages',
        ],
       
    ],
    'addations'  => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'options'       => 'Options',
            'status'        => 'Status',
            "name"          => " Name" ,
            "description"   => "Description",
            "price"         =>"Price" ,
            "icon"          => "Icon",

           
          
        ],
        'form'      => [
            
            'status'        => 'Status',
            "name"          => " Name" ,
            "description"   => "Description",
            "price"         =>"Price" ,
            "icon"          => "Icon",
            "type"          => "Type",
            'tabs'              => [
                'general'   => 'General Info.',
            ],
            "types"=>[
                "1"=> "Normal",
                "2" => "Stroy"
            ]

          
        ],
        'routes'    => [
            'create'    => 'Create Ads Addition',
            'index'     => 'Ads Additions',
            'update'    => 'Update Ads Addition',
        ],
       
    ],
    'ads'  => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'options'       => 'Options',
            'status'        => 'Status',
            "title"          => "Title" ,
            "description"   => "Description",
            "total"         =>"Total" ,
            "image"          => "Image",
            "start_at"       => "Start at",
            "end_at"       => "End at",
            "mobile"         => "Mobile ",
            "hide_private_number"=> "Hide private number",
            "duration"        => "Duration",
            "is_paid"         => "Is Paid",
            "type"         => "Type",
            "price"         => "Ads Price " ,
            "addation_total"   => "Addation total",
            "is_publish"       =>"Is publish",
            "ads_price"        => "Ads Price",
            "subscription_id"  => "Subscription",
            "user_id"         => "User",
            "office_id"         => "Office",
            "category_id"         => "Category ",
            "country_id"         => "Country",
            "city_id"         => "City",
            "state_id"         => "State",
            "addations"        => "Addations",
            "address"           => "Address",
            "status_enum"       => [
                "wait"      => "Wait ",
                "confirm"   => "Confirm and Paid",
                "publish"   => "Published",
                "expired"   => "Expired"
             ] ,
             "complaints"=> [
                "name"  => "Name",
                "message"=> "Message",
            
            ]
           
          
        ],
        'form'      => [
          
            'status'        => 'Status',
            "title"          => "Title" ,
            "description"   => "Description",
            "total"         =>"Total" ,
            "image"          => "Image",
            "start_at"       => "Start at",
            "end_at"       => "End at",
            "mobile"         => "Mobile ",
            "attachs"          => "Attachs",
            "hide_private_number"=> "Hide private number",
            "duration"        => "Duration",
            "is_paid"         => "Is Paid",
            "type"         => "Type",
            "price"         => "Ads Price " ,
            "addation_total"   => "Addation total",
            "is_publish"       =>"Is publish",
            "ads_price"        => "Ads Price",

            "user_id"         => "User",
            "office_id"         => "Office",
            "category_id"         => "Category ",
            "country_id"         => "Country",
            "city_id"         => "City",
            "state_id"         => "State",
            "addations"        => "Addations",
            "address"           => "Address",
            "subscription_id"  => "Subscription",

            'tabs'              => [
                'general'   => 'General Info.',
                "attachs"    => "attachs",
                "payment"     => "payment",
                "adsOrder"     => "Addation Order",
                "user"         => "User",
                "categories"     => "Category",
                "attrbiutes"    => "Atributes",
                "complaints"    =>"Complaints",
                "address"       => "Addresses",
            ],
            "take_from_subscription"=>"Take from subscription Or from free",
           
          
        ],
        'routes'    => [
            'create'    => 'Create Ads',
            'index'     => 'Ads',
            'update'    => 'Update Ads',
            "show"      => "Edit Ads",
        ],
       
    ],
   
];
