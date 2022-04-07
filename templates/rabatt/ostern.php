<?php ?>
<div>
    <ul class="rehorik-products products ostern">
        <?php
        if (wc_get_loop_prop('total')) {
            while (have_posts()) {
                the_post();

                /**
                 * Hook: woocommerce_shop_loop.
                 */
                do_action('woocommerce_shop_loop');

                get_template_part('templates/rabatt/content-product');
            }
        }
        ?>
    </ul>
</div>
