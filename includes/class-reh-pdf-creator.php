<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

require_once 'lib/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Reh_Pdf_Creator
{
    const DIR_NAME = 'reh-pdf';

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

        $filePath = self::get_file_path() . $file;

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

    public static function get_file_path(): string
    {
        $path = wp_upload_dir();
        $path = $path['basedir'] . '/' . self::DIR_NAME . '/';

        return trailingslashit($path);
    }
}
