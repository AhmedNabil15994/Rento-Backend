<?php

view()->composer(
    [
        'user::vendor.workers.create',
        'user::vendor.workers.edit',
        "user::dashboard.*",
        "ads::dashboard.ads.*"
     ],
    \Modules\Setting\ViewComposers\Dashboard\CountriesCodeComposer::class
);
