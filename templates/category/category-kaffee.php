<?php
defined( 'ABSPATH' ) || exit;

get_template_part('templates/header/head');
get_template_part('templates/page-title');
?>
    <div class="container">
        <div class="woocommerce-message" role="alert">
            Sorry, unsere Rohkaffeelieferung hat Verspätung, deswegen sind einige Sorten im Moment nicht lieferbar. Hoffentlich können wir bald wieder rösten, was das Zeug hält!
        </div>
        <div id="main-content">
<?php
get_template_part('templates/category/content');
