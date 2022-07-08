<?php
defined( 'ABSPATH' ) || exit;

get_template_part('templates/header/head');
get_template_part('templates/page-title');
?>
    <div class="container">
        <div class="woocommerce-message" role="alert">
            Aufgrund von Lieferproblemen beim Rohkaffee sind einige Kaffeesorten vorübergehend nicht lieferbar. Wir bitten Dich dafür um Verständnis. Hoffentlich können wir bald wieder rösten, was das Zeug hält!
        </div>
        <div id="main-content">
<?php
get_template_part('templates/category/content');
