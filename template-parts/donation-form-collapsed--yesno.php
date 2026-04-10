<?php
/**
 * finds whitespace closest to middle and inserts break
 */
if (!function_exists('darujme_form_whitespace')) {
    function darujme_form_whitespace(string $string): string {
        $len = strlen($string);
        $mid = (int)($len / 2);

        for ($offset = 0; $offset <= $mid; $offset++) {
            // Check left side first (prefer left when equidistant)
            if ($mid - $offset >= 0 && $string[$mid - $offset] === ' ') {
                $pos = $mid - $offset;
                return substr($string, 0, $pos) . ' <br>' . substr($string, $pos + 1);
            }

            // Check right side
            if ($mid + $offset < $len && $string[$mid + $offset] === ' ') {
                $pos = $mid + $offset;
                return substr($string, 0, $pos) . ' <br>' . substr($string, $pos + 1);
            }
        }

        return $string; // No whitespace found
    }
}

?>

<div class="darujme-collapsed-form" <?= !$args['collapsed'] ? 'style="display: none"' : '' ?>
    data-response-yes="<?= esc_attr(kapital_bubble_title($args['campaign_title_short'], 2, 'h3 mb-3 mt-2')) ?>"
    data-response-no="<?= esc_attr(kapital_bubble_title($args['campaign_title_short_no'], 2, 'h3 mb-3 mt-2')) ?>">
    <div class="row align-items-center justify-content-center gy-4 gy-md-5 gx-3 gx-sm-5 fw-bold ff-grotesk">
             <?php
        
/*             if (isset($args["campaign_title_short"])) if ($args["campaign_title_short"] !== "") echo '<div class="col-12 col-md-4 col-lg-3 darujme-form-heading fs-3">' . wpautop($args["campaign_title_short"]) . '</div>';
            if (isset($args["darujme_short_text"])) if ($args["darujme_short_text"] !== "") echo '<div class="col-12 col-md-5 col-lg-6 darujme-form-text me-auto">' . wpautop($args["darujme_short_text"]) . '</div>'
 */            ?> 

            <?php
            $yesno_btn_classes = 'btn darujme-form-expand-btn rounded whitespace-normal fw-bold fs-4 fs-sm-3 px-2 py-1';
            
            if (count($args['answer_yes'])): ?>
                <div class="col-12 col-md-auto yesno-row">
                    <div class="row gx-2 gy-2 gx-sm-4 align-items-center justify-content-center">
                        <?php foreach ($args['answer_yes'] as $key => $yes): ?>
                            <span class="col-auto btn-wrapper--yes" style="<?= $key === 0 ? 'visibility:hidden' : 'display:none' ?>">
                                <button class="<?= $yesno_btn_classes ?> btn--yes" data-yesno="yes"><?= darujme_form_whitespace($yes) ?></button>
                            </span>
                        <?php endforeach; ?>

                        <span class="col-auto fs-4 fs-sm-3 fw-bold"><?= __('alebo', 'kapital') ?></span>

                        <?php foreach ($args['answer_yes'] as $key => $yes): ?>
                            <span class="col-auto btn-wrapper--no" style="<?= $key === 0 ? 'visibility:hidden' : 'display:none' ?>">
                                <button class="<?= $yesno_btn_classes ?> btn--no" data-yesno="no"><?= darujme_form_whitespace($args['answer_no'][$key]) ?></button>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif;
            if (!empty($args['darujme_short_text'])): ?>        
                <p class="col-auto mb-0 short-text">
                    <?= darujme_form_whitespace($args['darujme_short_text'] )?>
                </p>
            
            <?php endif;?>
                        
        <div class="col-auto text-md-end">
            <button class="darujme-form-expand-btn btn <?= $yesno_btn_classes ?> btn--support" style="text-transform: unset" data-yesno="yes"><?= darujme_form_whitespace(__("Podpor Kapitál", "kapital")) ?></button>
        </div>
    </div>
</div>