<?php
defined( 'ABSPATH' ) || exit;

/** @var array $args passed render_settings */
$args;

$darujme_options = get_option('kapital_darujme_settings');

$titles = $darujme_options['modal_banner_title'] ?? [];
$texts = $darujme_options['modal_banner_text'] ?? [];
$btns_support = $darujme_options['modal_banner_btn_support'] ?? [];
$btns_support_url = $darujme_options['modal_banner_btn_support_url'] ?? [];
$btns_later = $darujme_options['modal_banner_btn_later'] ?? [];
$btns_supporting = $darujme_options['modal_banner_btn_supporting'] ?? [];




$version_count = max(count($titles), count($texts), count($btns_support), count($btns_support_url), count($btns_later), count($btns_supporting), 1);
do_action('qm/debug', $args['show_support']);


if ($darujme_options['campaign_active'] && $args['show_modal_banner'] && $darujme_options['modal_banner_active']):
/** aria-labelledby added dynamically via js to reference one of h2 titles */
?>
<div id="darujme-offcanvas-banner" class="darujme-offcanvas ff-grotesk offcanvas offcanvas-bottom bg-red text-white d-none show" tabindex="-1" data-bs-backdrop="false" data-bs-scroll="true">
    <div class="offcanvas-body px-3 py-0 alignwider">
    <?php 
    $c = 0;
    for ($c; $c < $version_count; $c++): ?>
    <div class="darujme-offcanvas__version py-5 d-flex flex-wrap gap-5 w-100 h-100 align-items-center justify-content-between darujme-offcanvas__version--<?= $c ?><?= $c > 0 ? ' d-none' : '' ?>">
        <div class="darujme-offcanvas__content-wrapper">
            <div class="darujme-offcanvas__logo">
                <svg viewBox="0 0 125 162"><use xlink:href="#kapital-logo-k" aria-hidden="true"></use></svg>
            </div>
            <div class="darujme-offcanvas__content alignnormal">
                <h2 class="mb-2"><?= $titles[$c] ?></h2>
                <p class="lh-sm"><?= $texts[$c] ?></p>
            </div>
        </div>
        <div class="darujme-offcanvas__actions d-inline-flex flex-column flex-sm-row flex-md-column flex-wrap gap-2">
            <a class="btn btn-black fs-2" href="<?= $btns_support_url[$c] ?>"><?= nl2br(esc_html($btns_support[$c])) ?></a>
            <button class="btn btn-black" data-darujme-d="3" data-bs-dismiss="offcanvas"><?= nl2br(esc_html($btns_later[$c])) ?></button>
            <button class="btn-link fw-bold underscore" data-darujme-d="183" data-bs-dismiss="offcanvas"><?= nl2br(esc_html($btns_supporting[$c])) ?></button>
        </div>
    </div>
    <?php endfor; ?>
    </div>
</div>

<?php endif;