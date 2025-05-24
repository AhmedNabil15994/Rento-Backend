<?php

foreach (["coupons.php", "packages.php", "addations.php", "ads.php", "republished_packages.php"] as  $value) {
    require_once(module_path('QSale', 'Routes/dashboard/'.$value));
}
