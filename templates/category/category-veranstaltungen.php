<?php
defined( 'ABSPATH' ) || exit;

$eventCat = getProductCategorySlug();
if (isProductCategory(TICKET_CATEGORY_SLUG) && !empty($eventCat)) {
    get_template_part('templates/header/head', null, ['slider' => [[
        'img'=> "header-${eventCat}"
    ]]]);
} else {
    get_template_part('templates/header/head');
}
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');
