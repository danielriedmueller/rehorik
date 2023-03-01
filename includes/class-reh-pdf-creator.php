<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

require_once 'lib/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Reh_Pdf_Creator
{
    public static function createPdf(
        string $file,
        string $template,
        array $templateData
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

        $filePath = get_temp_dir() . $file;

        ob_start();
        get_template_part($template, null, $templateData);
        $dompdf->loadHtml(ob_get_clean());
        $dompdf->setPaper('A4');
        $dompdf->render();

        if (file_put_contents($filePath, $dompdf->output())) {
            return $filePath;
        }

        return null;
    }
}
