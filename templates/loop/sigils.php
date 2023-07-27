<?php
require_once(get_stylesheet_directory() . '/helper/product_sigil_helper.php');
$product = $args['product'];
$sigils = getSigils($product);
$isEventOnlineClass = getIsEventOnlineClass($product);
?>
<?php if (!empty($sigils) || !empty($isEventOnlineClass)): ?>
    <div class="sigil-container">
        <?php
        if (!empty($isEventOnlineClass)) {
            echo sprintf('<div class="%s"></div>', $isEventOnlineClass);
        }

        if (!empty($sigils)) {
            foreach ($sigils as $sigil) {
                echo sprintf('<div title="%s" class="%s"></div>', $sigil['title'], $sigil['class']);
            }
        }
        ?>
    </div>
<?php endif; ?>