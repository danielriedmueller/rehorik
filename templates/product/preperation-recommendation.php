<?php
/** @var WC_Product $product */
$product = $args['product'];

$title = $product->get_title();

$category = null;
if (count($product->get_category_ids()) > 0)
    $category = getCategoryNameBySlug(get_term($product->get_category_ids()[0])->slug);

$value = $product->get_meta('reh_preperation_recommendation');

// If seperator ist not present, its legacy value format
$seperator = "|";
$textPieces = explode($seperator, $value);

$type = $textPieces[0];
$recipe = $textPieces[1];
$video = $textPieces[2];

if (empty($type) || empty($recipe) || empty($category)) {
    return;
}
?>
<h2>Zubereitungsempfehlung</h2>
<div class="description">
    <div>Dich hat die Abenteuerlust fest im Griff? Dann empfehlen wir, deinen <?= $title ?> in der
        <strong><?= $type ?></strong> zuzubereiten. Hier erfährst du mehr zur richtigen Zubereitung
        von <?= $category ?>.
    </div>
    <div><strong>Rezept:</strong> <span><?= $recipe ?></span></div>
    <div>Du hast keine <strong><?= $type ?></strong> daheim? Unser <?= $title ?> bringt dich auch mit jeder anderen
        Zubereitungsart zu Höchstleistungen - ganz so, wie DU es am Liebsten hast. Falls Du auf der Suche nach dem
        richtigen
        Kaffeezubehör bist – einfach einen persönlichen Beratungstermin vereinbaren und vorbeikommen.
    </div>
</div>
<?php get_template_part('templates/product/video', null, ['video' => $video]);
?>
<div class="make-appointment">
    <a class="button" target="_blank"
       href="https://app.resmio.com/rehorik-maschinenberatung/widget?backgroundColor=%235c0d2f&color=%23ceb67f&commentsDisabled=true&facebookLogin=false&&linkBackgroundColor=%23ceb67f&newsletterSignup=false">Beratungstermin
        vereinbaren</a>
</div>
