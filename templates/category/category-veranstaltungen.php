<?php
defined( 'ABSPATH' ) || exit;

get_template_part('templates/header/head');
if (isProductCategory(TICKET_CATEGORY_SLUG)) {
    $eventCat = getProductCategorySlug();
    if (!empty($eventCat)) {
        get_template_part("templates/veranstaltungen/header-${eventCat}");
    }
}
get_template_part('templates/page-title');
?>
    <div class="container">
        <div id="main-content">
<?php
get_template_part('templates/category/content');