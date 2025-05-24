<?php
foreach (["admins.php","users.php","workers.php"] as  $value) {
    require_once(module_path('User', 'Routes/dashboard/'.$value));
}
