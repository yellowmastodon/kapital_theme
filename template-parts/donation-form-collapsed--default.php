<?php
    //setup alternating colors per request, handled by js, so that we can cache the page
    $darujme_collapsed_colors = htmlentities(json_encode(array('#7065d6', '#000bdf', '#212529', '#008914')), ENT_QUOTES);

    /**
     * when ajax, there is no post context, and ajax insertion only happens on post
     * alt title text is used on non post pages
     */
    if ($post){
        if ($post->post_type !== 'post' && $args["campaign_title_short_alt"] !== ''){
            $args["campaign_title_short"] = $args["campaign_title_short_alt"];
        }
    }

?>

<div class="darujme-collapsed-form" <?= $args['collapsed'] ?? 'style="display: none"'; ?> data-colors="<?= $darujme_collapsed_colors ?>">
    <div class="row align-items-center justify-content-between gy-2 gx-5 fw-bold ff-grotesk">
            <?php
            if (isset($args["campaign_title_short"])) if ($args["campaign_title_short"] !== "") echo '<div class="col-12 col-md-4 col-lg-3 darujme-form-heading fs-3">' . wpautop($args["campaign_title_short"]) . '</div>';
            if (isset($args["darujme_short_text"])) if ($args["darujme_short_text"] !== "") echo '<div class="col-12 col-md-5 col-lg-6 darujme-form-text me-auto">' . wpautop($args["darujme_short_text"]) . '</div>'
            ?>
        <div class="col-12 col-md-3 text-md-end">
            <button class="darujme-form-expand-btn btn fw-bold whitespace-normal" style="text-transform: unset"><?= __("Podporte nás", "kapital") ?></btn>
        </div>
    </div>
</div>