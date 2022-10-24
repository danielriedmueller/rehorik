<?php

require_once 'lib/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Reh_Online_Coupon
{
    public static function createCoupon(float $value): string
    {
        $coupon = new WC_Coupon();

        $code = self::generateCouponCode();

        $coupon->set_code($code);
        $coupon->set_amount($value);

        $coupon->save();

        return $code;
    }

    // TODO: implement delete coupon. work in progress
    public static function deleteCoupon(string $code): void
    {
        $coupon = new WC_Coupon($code);
        $coupon->delete();
    }

    public static function createCouponPdf(
        string $code,
        string $price,
        string $name,
        int    $serialNumber
    ): ?string
    {
        $dompdf = new Dompdf([
            'enable_remote' => true,
        ]);
        $assetsDir = get_stylesheet_directory_uri() . '/assets/';
        $dompdf->getFontMetrics()->registerFont(
            ['family' => 'Cond', 'style' => 'normal', 'weight' => 'normal'],
            $assetsDir . '/fonts/cond.ttf'
        );

        $filePath = get_temp_dir() . 'Rehorik-Online-Coupon-' . date('Ymd') . $serialNumber . '.pdf';

        ob_start();
        get_template_part('/templates/online-coupon/coupon-pdf', null, [
            'code' => $code,
            'price' => $price,
            'name' => $name
        ]);
        $dompdf->loadHtml(ob_get_clean());
        $dompdf->setPaper('A4');
        $dompdf->render();

        if (file_put_contents($filePath, $dompdf->output())) {
            return $filePath;
        }

        return null;
    }

    private static function generateCouponCode(): string
    {
        $length = 7;
        return strtoupper(substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length));
    }
}
