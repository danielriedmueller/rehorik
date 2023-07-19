<?php
require_once(get_stylesheet_directory() . '/helper/page_helper.php');

$blocks = parse_blocks(get_the_content());
$table = '<table></table>';
$locations = [];
foreach ($blocks as $block) {
    if ($block['blockName'] === 'core/table') {
        $table = merge_inner_blocks([$block]);
    }

    if ($block['blockName'] === 'core/columns') {
        $location = [];
        foreach ($block['innerBlocks'] as $innerBlock) {
            $location[] = merge_inner_blocks($innerBlock['innerBlocks']);
        }
        $locations[] = $location;
    }
}

get_header();
?>
<div class="rehorik-page-introduction-outer">
    <div class="container max-width-small">
        <div class="rehorik-page-introduction locations">
            <div class="table-outer">
                <?= $table ?>
            </div>
        </div>
    </div>
</div>
<div id="locations-map"></div>
<div id="locations-description">
    <?php foreach ($locations as $location): ?>
        <div class="location">
            <div>
                <?php foreach ($location as $part): ?>
                    <div class="location-part"><?= $part ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php get_footer(); ?>
