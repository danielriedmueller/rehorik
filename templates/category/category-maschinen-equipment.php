<?php
defined( 'ABSPATH' ) || exit;

get_template_part('templates/header/head');
get_template_part('templates/machine-header');
get_template_part('templates/page-title');

?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');