<?php

namespace Modules\QSale\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckCoupon implements Rule
{
    public $price;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($price)
    {
        //
        $this->price = $price;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $coupon = Coupon::unExpired()->active()->notLimited()
                ->where("code", $value)->first();
        if(!$coupon) return false;
        return $coupon->checkAllow($this->price);        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("qsale::dashboaed.coupons.validation");
    }
}
