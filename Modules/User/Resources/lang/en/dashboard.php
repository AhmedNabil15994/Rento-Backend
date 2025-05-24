<?php

return [
    'admins'        => [
        'create'    => [
            'form'  => [
                'confirm_password'  => 'Confirm Password',
                'email'             => 'Email',
                'general'           => 'General Info.',
                'image'             => 'Profile Image',
                'info'              => 'Info.',
                'mobile'            => 'Mobile',
                'name'              => 'Name',
                'password'          => 'Password',
                'roles'             => 'Roles',
                "not_roles"         => "Not Added any roles yeat"
            ],
            'title' => 'Create Admins',
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'email'         => 'Email',
            'image'         => 'Image',
            'mobile'        => 'Mobile',
            'name'          => 'Name',
            'options'       => 'Options',
        ],
        'index'     => [
            'title' => 'Admins',
        ],
        'update'    => [
            'form'  => [
                'confirm_password'  => 'Confirm Password',
                'email'             => 'Email',
                'general'           => 'General info.',
                'image'             => 'Profile Image',
                'mobile'            => 'Mobile',
                'name'              => 'Name',
                'password'          => 'Change Password',
                'roles'             => 'Roles',
            ],
            'title' => 'Update Admins',
        ],
        'validation'=> [
            'email'     => [
                'required'  => 'Please enter the email of admin',
                'unique'    => 'This email is taken before',
            ],
            'mobile'    => [
                'digits_between'    => 'Please add mobile number only 8 digits',
                'numeric'           => 'Please enter the mobile only numbers',
                'required'          => 'Please enter the mobile of admin',
                'unique'            => 'This mobile is taken before',
            ],
            'name'      => [
                'required'  => 'Please enter the name of admin',
            ],
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'Please enter the password of admin',
                'same'      => 'The Password confirmation not matching',
            ],
            'roles'     => [
                'required'  => 'Please select the role of admin',
            ],
        ],
    ],
    'users'         => [
        'create'    => [
            'form'  => [
                'confirm_password'  => 'Confirm Password',
                'email'             => 'Email',
                'general'           => 'General Info.',
                'image'             => 'Profile Image',
                'mobile'            => 'Mobile',
                'name'              => 'Name',
                'password'          => 'Password',
                "country"           => "Country",
                "restore"           => "Restore",
                "user_name"         =>  "User Name" ,
                "status"            => "Status",
                "number_of_free"    =>"Number of free ads",
                "is_verified"       => "Is verified",

                "type"              => "Type",
                "user"              => "User",
                "office"            => "Office" ,
                "country_id"        => "Country",
                "city_id"           => "City",
                "state_id"          => "State",
                "package_id"        => "Package",
                'title'              => 'Office title',
                'office_image'           => 'Office Logo',
                "description"       => "Description" ,
                "categories"        => "Categories",

                
            ],
            'title' => 'Create Users',
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'email'         => 'Email',
            "status"            => "Status",
            'image'         => 'Image',
            "gender"            => "Gender" ,
            'mobile'        => 'Mobile',
            'name'          => 'Name',
            'options'       => 'Options',
            "number_of_free"    =>"Number of free ads",
            "is_verified"       => "Is verified",
            "type"              => "Type",
            "user"              => "User",
            "office"            => "Office" ,
            "country_id"        => "Country",
            "city_id"           => "City",
            "state_id"          => "State",
            "package_id"        => "Package",
            'title'              => 'Office title',
            'office_image'           => 'Office Logo',
            "description"       => "Description" ,
            "currentSubscription"=> [
                "tab" => "Current Subscription" ,
                "is_free" => "is free",
                "start_at"  => "Start at" ,
                "end_at"  => "End at" ,
                "current_use"  => "Current use" ,
                "max_use"  => "Max use" ,
                "money"  => "Price " ,
                "duration" => "Duration",
                "renewal_at" => "Renewal at" ,
                "renewal_count" => "Renewal count" ,
                "renewal"       => "Renewal Subscription",
                "duration_of_ads" => "Period to show ads",
            ]
            
           

        ],
        'index'     => [
            'title' => 'Users',
        ],
        'update'    => [
            'form'  => [
                'confirm_password'  => 'Confirm Password',
                'email'             => 'Email',
                'general'           => 'General info.',
                'image'             => 'Profile Image',
                'mobile'            => 'Mobile',
                'name'              => 'Name',
                'password'          => 'Change Password',
                "description"       => "Description" ,
                "is_verified"       => "Is verified",
                "type"              => "Type",
                "user"              => "User",
                "office"            => "Office" ,
                "country_id"        => "Country",
                "city_id"           => "City",
                "state_id"          => "State",
                "package_id"        => "Package",
                'title'              => 'Office title',
                'office_image'           => 'Office Logo',
                "categories"        => "Categories",
                "description"       => "Description" ,
                "currentSubscription"=> [
                    "tab" => "Current Subscription" ,
                    "is_free" => "is free",
                    "start_at"  => "Start at" ,
                    "end_at"  => "End at" ,
                    "current_use"  => "Current use" ,
                    "max_use"  => "Max use" ,
                    "money"  => "Price " ,
                    "duration" => "Duration",
                    "renewal_at" => "Renewal at" ,
                    "renewal_count" => "Renewal count" ,
                    "renewal"       => "Renewal Subscription",
                    "duration_of_ads" => "Period to show ads",
                ]
               
            ],
            'title' => 'Update User',
        ],
        'validation'=> [
            'email'     => [
                'required'  => 'Please enter the email of user',
                'unique'    => 'This email is taken before',
            ],
            'mobile'    => [
                'digits_between'    => 'Please add mobile number only 8 digits',
                'numeric'           => 'Please enter the mobile only numbers',
                'required'          => 'Please enter the mobile of user',
                'unique'            => 'This mobile is taken before',
            ],
            'name'      => [
                'required'  => 'Please enter the name of user',
            ],
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'Please enter the password of user',
                'same'      => 'The Password confirmation not matching',
            ],
        ],
    ],
    'users'         => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'email'         => 'Email',
            "status"            => "Status",
            'image'         => 'Image',
            "gender"            => "Gender" ,
            'mobile'        => 'Mobile',
            'name'          => 'Name',
            'options'       => 'Options',
            "number_of_free"    =>"Number of free ads",
            "is_verified"       => "Is verified",
            "type"              => "Type",
            "user"              => "User",
            "office"            => "Office" ,
            "country_id"        => "Country",
            "city_id"           => "City",
            "state_id"          => "State",
            "package_id"        => "Package",
            'title'              => 'Office title',
            'office_image'           => 'Office Logo',
            "description"       => "Description" ,
            "currentSubscription"=> [
                "tab" => "Current Subscription" ,
                "is_free" => "is free",
                "start_at"  => "Start at" ,
                "end_at"  => "End at" ,
                "current_use"  => "Current use" ,
                "max_use"  => "Max use" ,
                "money"  => "Price " ,
                "duration" => "Duration",
                "renewal_at" => "Renewal at" ,
                "renewal_count" => "Renewal count" ,
                "renewal"       => "Renewal Subscription",
                "duration_of_ads" => "Period to show ads",
            ]
            
           

        ],
        'index'     => [
            'title' => 'Offices',
        ],
     
       
    ],
   
    
   
];
