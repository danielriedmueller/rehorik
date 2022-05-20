<?php
// Add admin page
add_action( 'admin_menu', function() {
    add_menu_page('Rehorik', 'Rehorik', 'administrator', 'rehorik-admin', function() {
        ?>
            <div>
            </div>
        <?php
    }, null, 3);
});


add_action( 'admin_enqueue_scripts', function($hook) {
    if ($hook == 'toplevel_page_rehorik-admin') {
        $assetsDir = get_stylesheet_directory_uri() . '/assets/';
        // wp_enqueue_script('rehorik-admin', $assetsDir . 'js/admin.js', array('jquery'), 1, false);
    }
});

/*
add_action('wp_ajax_create_sigil_attributes', function() {
    try {
        $guetesiegel = 'pa_guetesiegel';
        $products = wc_get_products(array( 'status' => 'publish', 'limit' => -1 ));

        $updateAttribute = function($attribute, $product) use ($guetesiegel) {
            wp_set_object_terms($product->get_id(), $attribute, $guetesiegel, true);
            $product_attributes = get_post_meta( $product->get_id() ,'_product_attributes', true);
            $product_attributes[$guetesiegel] = [
                'name' => $guetesiegel,
                'value' => $attribute,
                'is_visible' => '1',
                'is_taxonomy' => '1'
            ];
            update_post_meta($product->get_id(), '_product_attributes', $product_attributes);
        };

        foreach ($products as $product) {
            if (!empty($product->get_attribute('biodynamisch'))) {
                $updateAttribute('biodynamisch', $product);
            }

            if (!empty($product->get_attribute('biosiegel'))) {
                $updateAttribute('biosiegel', $product);
            }

            if (!empty($product->get_attribute('product-of-month'))) {
                $updateAttribute('produkt-des-monats', $product);
            }
            if (!empty($product->get_attribute('regional'))) {
                $updateAttribute('regional', $product);
            }
        }

        echo "OK";
    } catch (Exception $exception) {
        echo "error: " . $exception->getMessage();
    }
});
*/