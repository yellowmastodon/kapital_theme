<?php
    $ecomail_enabled = false;
    $ecomail_enabled_for_post = false;
    $show_heading = false;
    $ecomail_post_url = "";
    $ecomail_gdpr = "";
    $additional_classes = "";
    if (isset($args["ecomail_enabled"])){
        $ecomail_enabled = $args["ecomail_enabled"];
    }
    if (isset($args["ecomail_post_url"])){
        $ecomail_post_url = $args["ecomail_post_url"];
    }
    if (isset($args["show_footer_newsletter"])){
        $ecomail_enabled_for_post = $args["show_footer_newsletter"];
    }
    if (isset($args["show_heading"])){
        $show_heading = $args["show_heading"];
    }
    if (isset($args["ecomail_gdpr"])){
        $ecomail_gdpr = $args["ecomail_gdpr"];
    }
    if (isset($args["additional_classes"])){
        $additional_classes = " " . $args["additional_classes"];
    }

    if ($ecomail_enabled_for_post && $ecomail_enabled && $ecomail_post_url !== ""): ?>
        <div id="#newsletter-prihlasenie" class="alignnarrow text-center<?=$additional_classes?>">
            <?php if ($show_heading):?>
               <h2 class="text-uppercase mb-3"><?= __("Newsletter", "kapital") ?></h2>
            <?php endif; ?>
            <form method="post" action="<?= $ecomail_post_url . '?source=Web:päta' ?>">
                <label for="ecomail_email" class="visually-hidden"><?=__("Email*", "kapital")?></label>
                <input id="ecomail_email" class="rounded-0 border-top-0 border-start-0 border-end-0 ps-0 py-1 mb-4" type="email" name="email" required placeholder="<?=__("Email*", "kapital") ?>" />
                <?php if (isset($ecomail_gdpr) && $ecomail_gdpr !== ""):?>
                    <p class="fs-small lh-sm ff-sans mb-4">
                        <?=$ecomail_gdpr?>
                    </p>
                <?php endif;?>

                <button class="btn btn-primary fw-bold" type="submit"><?= __("Prihlásiť k odberu", "kapital") ?></button>
            </form>
        </div>
    <?php endif;
    ?>