<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined('ABSPATH') || exit;

if (isProductCategory(BLACK_AND_WINE)) {
    get_template_part('templates/veranstaltungen/black-and-wine');
} else {
    get_template_part('templates/loop/subcategories_chooser');
    ?>
    <button id="product-filter-button">Filtern & Sortieren</button>
    <p class="woocommerce-info">
        <?php
        if (isProductCategory(TICKET_CATEGORY_SLUG)) {
            echo "Momentan sind alle Termine ausgebucht.";
        } else {
            esc_html_e('No products were found matching your selection.', 'woocommerce');
        }
        ?>
    </p>
<?php } ?>
