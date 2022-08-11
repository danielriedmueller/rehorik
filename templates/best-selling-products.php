<?php
// TODO: change medium size to 350 in /wp-admin/options-media.php
$productList = [1338, 26245, 18738, 674];
?>
  <div class="slider-outer" id="rehorik-best-selling-products">
    <ul id="slider-body" class="slider">
        <?php
        foreach ($productList as $productId) {
            $product = wc_get_product($productId);
            if ($product) {
                echo sprintf(
                    '<li><div><div><a href="%s">%s</a></div><div><span>%s</span><a class="button" href="%s">%s</a></div></div></li>',
                    $product->get_permalink(),
                    $product->get_image('medium'),
                    $product->get_description(),
                    $product->get_permalink(),
                    $product->get_title(),
                );
            }
        }
        ?>
    </ul>
    <div id="slider-body-controls" class="slider-controls">
        <button></button>
        <button></button>
    </div>
</div>
