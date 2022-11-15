<?php

$mergeDescriptions = function ($description, $shortDescription, $claim) {
    $cleanUpText = function($text) {
        if (empty($text)) {
            return "";
        }

        $text = str_replace( '</li>', ', ', $text);
        $text = ucfirst(trim(strip_tags($text)));
        $text = rtrim($text, ',');

        if (!str_ends_with($text, '.') && !str_ends_with($text, '?') && !str_ends_with($text, '!')) {
            $text .= '.';
        }

        return $text;
    };

    $result = $shortDescription ? $cleanUpText($description) . ' ' . $cleanUpText($shortDescription) : $cleanUpText($description);

    $charsToNewLine = 52;
    $claimLength = strlen($claim);
    $claimLines = $claimLength > 0 ? (int) ceil($claimLength / $charsToNewLine) : 0;
    $width = 350 - $charsToNewLine * $claimLines;

    return mb_strimwidth($result, 0, $width, "...");
};

$link = "/produkt-kategorie/onlineshop/geschenke-gutscheine/geschenke/";
?>
<div class="featured-product">
    <div class="image">
        <a href="<?= $link ?>"><img src="/wp-content/uploads/2022/10/amore-vino-690px-350x350.jpg" /></a>
    </div>
    <div class="text">
        <h3><a href="<?= $link ?>">Geschenke</a></h3>
        <span class="claim">Etwas für unterm Baum gesucht?</span>
        <span class="description">Hier findet Ihr die perfekten Geschenke für befreundete Feinschmecker:innen oder Schmankerl für verwandt Genießer:innen. Wir haben das Beste aus unseren Wein- und Delikatessenregalen geholt und schon mal ein paar Geschenk zusammengestellt.</span>
        <span class="learn-more"><a href="<?= $link ?>">erfahre mehr</a></span>
    </div>
</div>