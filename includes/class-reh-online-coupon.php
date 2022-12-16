<?php

require_once 'lib/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

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
        $dompdf = new Dompdf([
            'enable_remote' => true,
            'dpi' => 300
        ]);
        $assetsDir = get_stylesheet_directory_uri() . '/assets/';
        $dompdf->getFontMetrics()->registerFont(
            ['family' => 'Cond', 'style' => 'normal', 'weight' => 'normal'],
            $assetsDir . '/fonts/cond.ttf'
        );
        $dompdf->getFontMetrics()->registerFont(
            ['family' => 'Cond Bold', 'style' => 'normal', 'weight' => 'bold'],
            $assetsDir . '/fonts/cond-bold.ttf'
        );

        $filePath = get_temp_dir() . 'Rehorik-Online-Coupon-' . date('Ymd') . $serialNumber . '.pdf';

        ob_start();
        get_template_part('/templates/online-coupon/coupon-pdf', null, [
            'code' => BAYERNWERK_COUPON_CODE,
            'price' => '15',
            'name' => 'bag2future'
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
        $length = 8;
        return strtoupper(substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length));
    }
}
