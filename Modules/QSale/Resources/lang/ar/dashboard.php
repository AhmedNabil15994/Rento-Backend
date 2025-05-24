<?php

return [
    'coupons'  => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            "code"         => "الكود" ,
            'min'              => 'اقل قيمه ',
            'max'               => ' اقصى قيمه فى حالة النسه ',
            "amount"            => "الخصم" ,
            "expired_at"        => "تاريخ الانتهاء",
            "max_use"           => "اقصى عدد مرات لاستخدام",
            "current_use"       => "عدد مرات الاستخدام",
            "max_use_user"      => " اقصى مرات استخدام للشخص ",
            "is_fixed"          => " قيمة ثابته" ,
           
          
        ],
        'form'      => [
            'status'        => 'الحالة',
            "code"         => "الكود" ,
            'min'              => 'اقل قيمه ',
            'max'               => ' اقصى قيمه فى حالة النسه ',
            "amount"            => "الخصم" ,
            "expired_at"        => "تاريخ الانتهاء",
            "max_use"           => "اقصى عدد مرات لاستخدام",
            "current_use"       => "عدد مرات الاستخدام",
            "max_use_user"      => " اقصى مرات استخدام للشخص ",
            "is_fixed"          =>" قيمة ثابته" ,
            'tabs'              => [
                'general'   => 'بيانات عامة',
            ],
          
        ],
        'routes'    => [
            'create'    => 'اضافة كوبون ',
            'index'     => ' الكوبونات ',
            'update'    => 'تعديل كوبون',
        ],
        'validation'=> [
            "not_valid" => "الكوبون غير صالح "
        ],
    ],
    'packages'  => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            "is_free"       => "مجانيه" ,
            "title"       => "العنوان" ,
            "description" => "الوصف",
            "price"     =>"السعر" ,
            "duration"  =>"المده" ,
            "number_of_ads" => "عدد الاعلانات",
            "number_of_image" => "عدد الصور",
            "duration_of_ads"  => "مدة الاعلان",
          
        ],
        'form'      => [
            
            'status'        => 'الحالة',
            "is_free"       => "مجانيه" ,
            "title"       => "العنوان" ,
            "description" => "الوصف",
            "price"     =>"السعر" ,
            "duration"  =>"المده" ,
            "number_of_ads" => "عدد الاعلانات",
            "sort"          => "ترتيب الظهور",
            "number_of_image" => "عدد الصور" ,
            "duration_of_ads"  => "مدة الاعلان",
            "first_time" => "اول مره",
            "type"       => "نوع الباقه",
            "types"      => [
                "user"      => "مستخدم",
                "office"   => "شركه",
            ],
            'tabs'              => [
                'general'   => 'بيانات عامة',
            ],
          
        ],
        'routes'    => [
            'create'    => 'اضافة باقة للمكاتب ',
            'index'     => ' باقات المكاتب ',
            'update'    => 'تعديل  باقة مكتب',
        ],
       
    ],
    'republished_packages'  => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            "is_free"       => "مجانيه" ,
            "title"       => "العنوان" ,
            "description" => "الوصف",
            "price"     =>"السعر" ,
            "duration"  =>"المده" ,
          
        ],
        'form'      => [
            
            'status'        => 'الحالة',
            "is_free"       => "مجانيه" ,
            "title"       => "العنوان" ,
            "description" => "الوصف",
            "price"     =>"السعر" ,
            "duration"  =>"المده" ,
            'tabs'              => [
                'general'   => 'بيانات عامة',
            ],
          
        ],
        'routes'    => [
            'create'    => 'اضافة باقة لاعادة النشر ',
            'index'     => ' باقات لاعادة النشر ',
            'update'    => 'تعديل  باقة النشر',
        ],
       
    ],
    'addations'  => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            "name"          => " الاسم" ,
            "description"   => "الوصف",
            "price"         =>"السعر" ,
            "icon"          => "الايقونه",
           
          
        ],
        'form'      => [
            
            'status'        => 'الحالة',
            "name"          => " الاسم" ,
            "description"   => "الوصف",
            "price"         =>"السعر" ,
            "icon"          => "الايقونه",
            "type"          => "النوع",
            'tabs'              => [
                'general'   => 'بيانات عامة',
            ],
            "types"=>[
                "1"=> "العادى",
                "2" => "قصة"
            ]
          
        ],
        'routes'    => [
            'create'    => 'اضافة اصافة اعلان ',
            'index'     => '  اضافات الاعلانات ',
            'update'    => 'تعديل اضافة اعلان',
        ],
       
    ],
    'ads'  => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            "title"          => "عنوان" ,
            "description"   => "الوصف",
            "total"         =>"اجمالى السعر" ,
            "image"          => "الصوره",
            "start_at"       => "يبدء في",
            "end_at"       => "ينتهى في",
            "mobile"         => "رقم الجوال ",
            "hide_private_number"=> "اخفاء الرقم الخاص",
            "duration"        => "المده",
            "is_paid"         => "تم الدفع",
            "type"         => "نوع الاعلان",
            "price"         => "سعر الاعلان" ,
            "addation_total"   => "اجمالى الاضافة",
            "is_publish"       =>"متاح للمشاهده", 
            "ads_price"        => "سعر الخاص بالاعلان",
            "subscription_id"  => "الاشتراك",
            "user_id"         => "المستختدم",
            "office_id"         => "المكتب",
            "category_id"         => "نوع الاعلان",
            "country_id"         => "البلد",
            "city_id"         => "المدينه",
            "state_id"         => "المنطقه",
            "addations"        => "الاضافات", 
            "address"           => "العناوين",
            "status_enum"       => [
                "wait"      => "الانتظار ",
                "confirm"   => "تم التاكيد والدقع",
                "publish"   => "منشور",
                "expired"   => "تم الانتهاء"
             ] ,
             "complaints"=> [
                "name"  => "الاسم",
                "message"=> "البلاغ",
            
            ]   
           
          
        ],
        'form'      => [
          
            'status'        => 'الحالة',
            "title"          => "عنوان" ,
            "description"   => "الوصف",
            "total"         =>"اجمالى السعر" ,
            "image"          => "الصوره الاساسيه",
            "attachs"          => "المرفقات",
            "start_at"       => "يبدء في",
            "end_at"       => "ينتهى في",
            "mobile"         => "رقم الجوال ",
            "hide_private_number"=> "اخفاء الرقم الخاص",
            "duration"        => "المده",
            "is_paid"         => "تم الدفع",
            "type"         => "نوع الاعلان",
            "price"         => "سعر الاعلان" ,
            "addation_total"   => "اجمالى الاضافة",
            "ads_price"        => "سعر الخاص بالاعلان",
            "subscription_id"  => "الاشتراك",
            "user_id"         => "المستختدم",
            "office_id"         => "المكتب",
            "category_id"         => "نوع الاعلان",
            "country_id"         => "البلد",
            "city_id"         => "المدينه",
            "state_id"         => "المنطقه",
            'tabs'              => [
                'general'   => 'بيانات عامة',
                "attachs"    => "المرفقات",
                "payment"     => "عملية الدفع",  
                "adsOrder"     => "الاضافات المضافه", 
                "user"         => "المستختدم", 
                "categories"     => "نوع الخدمه",
                "attrbiutes"    => "الصفات",
                "complaints"    =>"البلاغات",
                "address"       => "العناوين",
            ],
            "addations" => "الاضافات",
            "take_from_subscription"=>"خصم من المجانى او الاشتراك",
           
          
        ],
        'routes'    => [
            'create'    => 'اضافة  اعلان ',
            'index'     => 'الاعلانات ',
            'update'    => 'تعديل  اعلان',
            "show"      => "تفاصيل الاعلان",
        ],
       
    ],
   
];
