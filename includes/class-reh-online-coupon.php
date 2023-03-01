<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

class Reh_Online_Coupon
{
    public static function createCoupon(float $value, int $orderNumber): string
    {
        $coupon = new WC_Coupon();

        $code = self::generateCouponCode();

        $coupon->set_code($code);
        $coupon->set_amount($value);
        $coupon->set_description('Erstellt durch Bestellung #' . $orderNumber);

        $coupon->save();

        return $code;
    }

    public static function createCouponPdf(
        string $code,
        string $price,
        string $name,
        int    $serialNumber
    ): ?string
    {
        $file = 'Rehorik-Online-Coupon-' . date('Ymd') . $serialNumber . '.pdf';

        return Reh_Pdf_Creator::createPdf(
            $file,
            '/templates/pdf/coupon-pdf',
            [
                'code' => $code,
                'price' => $price,
                'name' => $name
            ]
        );
    }

    private static function generateCouponCode(): string
    {
        $length = 8;
        return strtoupper(substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length));
    }
}
