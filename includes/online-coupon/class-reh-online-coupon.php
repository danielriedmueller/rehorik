<?php

require_once 'lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class Reh_Create_Coupon
{
    private Dompdf $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }

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

    private function generateCouponCode(): string
    {
        $length = 6;
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    /**
     * @throws \Dompdf\Exception
     */
    public function createCouponPdf(string $code): ?string
    {
        $filePath = get_temp_dir() . 'Coupon2.pdf';

        ob_start();
        require("html-to-pdf/coupon_mail.html");
        $this->dompdf->loadHtml(ob_get_clean());
        $this->dompdf->setPaper('A4');
        $this->dompdf->render();

        if (file_put_contents($filePath, $this->dompdf->output())) {
            return $filePath;
        }

        return null;
    }
}
