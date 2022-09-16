<?php

class Reh_Create_Coupon
{
    public function createCoupon(float $value): string
    {
        $coupon = new WC_Coupon();

        $code = $this->generateCouponCode();
        $coupon->set_code($code); // Coupon code
        $coupon->set_amount($value); // Discount amount

        $coupon->save();

        return $code;
    }

    private function generateCouponCode(): string
    {
        $length = 5;
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
}
