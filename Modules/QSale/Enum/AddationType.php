<?php
namespace Modules\QSale\Enum;

class AddationType extends \SplEnum{
    
    const NORMAL=1;
    const STORY=2;


    public static $icons = [
        1 =>"<i class='fas fa-clipboard-check'></i>"  , 
        2 => " <i class='fas fa-fire'></i>" 
    ];
    
}