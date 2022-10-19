<?php

require_once 'lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

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

    public function deleteCoupon(string $code): void
    {
        $coupon = new WC_Coupon($code);
        $coupon->delete();
    }

    public function createCouponPdf(string $code): ?string
    {
        $dompdf = new Dompdf();
        $filePath = get_temp_dir() . 'Coupon.pdf';

        ob_start();
        get_template_part('/templates/online-coupon/coupon-pdf', null, ['code' => $code]);
        $dompdf->loadHtml(ob_get_clean());
        $dompdf->setPaper('A4');
        $dompdf->render();

        if (file_put_contents($filePath, $dompdf->output())) {
            return $filePath;
        }

        return null;
    }

    private function generateCouponCode(): string
    {
        $length = 6;
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
}
