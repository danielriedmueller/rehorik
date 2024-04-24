<?php
require_once(get_stylesheet_directory() . '/helper/page_helper.php');

$blocks = parse_blocks(get_the_content());
$jobs = [];
foreach ($blocks as $block) {
    if ($block['blockName'] === 'core/group') {
        $jobs[] = merge_inner_blocks([$block]);
    }
}

get_header();
?>
<div id="jobs">
    <?php foreach ($jobs as $job): ?>
        <div class="job-description-outer">
            <div class="container">
                <div class="job-description">
                    <?= $job ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="container">
        <div class="apply-now">
            <h2>Dein Job ist nicht dabei?</h2>
            <p>und du möchtest Teil unseres Teams werden? Schick uns einfach eine Mail und wir kontaktieren dich.</p>
            <a class="button" href="mailto:<?= JOBS_MAIL ?>">Jetzt bewerben</a>
        </div>
    </div>
</div>
<?php get_footer(); ?>

