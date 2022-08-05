<?php
/** @var WC_Product $product */
$product = $args['product'];

$value = $product->get_meta('reh_preperation_recommendation');

// If seperator ist not present, its legacy value format
$seperator = "|";
$textPieces = explode($seperator, $value);
?>
<div class="rehorik-recommendation"><?php if (!str_contains($value, $seperator)): ?><?= $value ?><?php else: ?><?php if (!empty($textPieces[0]) || !empty($textPieces[1])): ?><div><h5>Zubereitungsempfehlung</h5></div><?php if (!empty($textPieces[0])): ?><div><strong>Typ:</strong> <span><?= $textPieces[0] ?></span></div><?php endif; ?><?php if (!empty($textPieces[1])): ?><div><strong>Rezept:</strong> <span><?= $textPieces[1] ?></span></div><?php endif; ?><?php endif; ?><?php endif; ?></div>
