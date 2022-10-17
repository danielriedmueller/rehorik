<?php

class Reh_Create_Coupon
{
    public function createCoupon(float $value): string
    {
        $coupon = new WC_Coupon();

        $code = $this->generateCouponCode();
        $coupon->set_code($code); // Coupon code
        $coupon->set_amount($value); // Discount amount
        $coupon->set_usage_limit(1);

        $coupon->save();

        return $code;
    }

    public function deleteCoupon(string $code): void
    {
        $coupon = new WC_Coupon($code);
        $coupon->delete();
        // send mail
        //wp_mail('it@rehorik.de', 'Coupon deleted', 'foobarfoo');
    }

    private function generateCouponCode(): string
    {
        $length = 6;
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
}
