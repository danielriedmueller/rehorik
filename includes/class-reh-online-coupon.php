<?php

require_once get_stylesheet_directory() . '/lib/dompdf/autoload.inc.php';
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
        $coupon->set_usage_limit(1);

        $coupon->save();

        $filePath = $this->createCouponPdf($code);

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

    private function createCouponPdf(string $code): string
    {
        $this->dompdf->loadHtml($code);
        $this->dompdf->setPaper('A4', 'landscape');
        $this->dompdf->render();

        $f = file_put_contents(get_temp_dir() . '/Coupon2.pdf', $this->dompdf->output());
        print $f;

        return "";
    }
}
