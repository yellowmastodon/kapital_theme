<?php
defined( 'ABSPATH' ) || exit;
//whether to render form as collapsed
$collapsed_class = "";
$show_title = true;
$collapsed = false;
if (isset($args["collapsed"])){
    if ($args["collapsed"]){
        $collapsed_class = " collapsed";
        $collapsed = true;
    }
}
if (isset($args["show_title"])){
    if (!$args["show_title"]){
        $show_title = false;
    }
}
$darujme_options = get_option('kapital_darujme_settings');
$darujme_onetime_amounts = $darujme_options['donation_amount_onetime'];
$campaign_active = false;
if (isset($darujme_options["campaign_active"])) if ($darujme_options["campaign_active"]) $campaign_active = true;
if ($campaign_active):
    $darujme_onetime_amounts = explode(",", $darujme_onetime_amounts);
    $darujme_onetime_amounts =  array_map(function ($item) {
        $item = trim($item);
        return $item;
    }, $darujme_onetime_amounts);
    $darujme_periodical_amounts = $darujme_options['donation_amount_periodical'];
    $darujme_periodical_amounts = explode(",", $darujme_periodical_amounts);
    $darujme_periodical_amounts =  array_map(function ($item) {
        $item = trim($item);
        return $item;
    }, $darujme_periodical_amounts);
    $title = $darujme_options["campaign_title"];
    $long_text = $darujme_options["darujme_long_text"];
    $short_text = $darujme_options["darujme_short_text"];
    $gdpr_link = $darujme_options["darujme_kapital_gdpr_url"];
    ?>
    <div id="darujme-form-wrapper" class="alignwide my-5 bg-primary<?=$collapsed_class?>">
        <div id="darujme-collapsed-form" <?php if (!$collapsed) echo 'style="display: none"';?>>
            <div class="row align-items-center gy-4 gx-3">
                <div class="col">
                    <?php
                    if (isset($short_text)) if ($short_text !== "") echo '<div class="ff-grotesk fw-bold text-center text-md-start lh-sm">' . wpautop(auto_nbsp($short_text)) . '</div>'
                    ?>
                </div>
                <div class="col-12 col-md-auto text-center">
                    <button id="darujme-form-expand-btn" class="btn fw-bold btn-white"><?= __("Podporte nás", "kapital") ?></btn>
                </div>
            </div>
        </div>
        <div id="darujme-expanded-form" <?php if ($collapsed) echo 'style="display: none"';?>>
            <?php
            $descriptive_paragraphs_classes = "ff-grotesk col-12 mb-0 lh-sm mt-4";
            if ($show_title) if (isset($title)) if ($title !== "") echo kapital_bubble_title($title, 2, 'h3 mb-3 mt-2');
            if (isset($long_text)) if ($long_text !== "") echo '<div class="ff-grotesk py-3 pb-4">' . wpautop(auto_nbsp($long_text)) . '</div>'
            ?>
            <form id="darujme-form" action="https://api.darujme.sk/v1/donations/post/" method="post" enctype="application/x-www-form-urlencoded" class="darujme-form needs-validation">
                <input type="hidden" class="form-control" name="campaign_id" id="campaign_id" value="<?= $darujme_options["campaign_id"] ?>" required>
                <input type="hidden" name="value" id="darujme_value" value="">
                <input type="hidden" name="kind" id="darujme_kind" value="person">
                <input name="payment_method_id" id="darujme_payment_method_id" type="hidden" value="">

                <div id="periodicity" class="row gx-1 gy-1 mb-2">
                    <p class="<?=$descriptive_paragraphs_classes?>">Ako často chcete prispievať?</p>
                    <div class="col-12 col-sm-6"><input class="darujme-radio-input-btn" name="periodicity" type="radio" id="onetime" value="onetime"><label class="btn btn-outline btn-block" for="onetime"><?php echo __("Jednorazovo", "kapital") ?></label></div>
                    <div class="col-12 col-sm-6"><input class="darujme-radio-input-btn" name="periodicity" type="radio" id="periodical" value="periodical" checked><label class="btn btn-outline btn-block" for="periodical"><?php echo __("Mesačne", "kapital") ?></label></div>
                </div>
                <section id="onetime_fixed_values" class="mb-2">
                    <div class="row gx-1 gy-1">
                        <p class="<?=$descriptive_paragraphs_classes?>">Koľko chcete prispieť?</p>
                        <?php foreach ($darujme_onetime_amounts as $key => $amount):
                            if ($amount !== "" && $amount !== "0"):
                                if ($key === 1) {
                                    $checked = ' checked="checked"';
                                } else {
                                    $checked = '';
                                } ?>
                                <div class="col"><input class="darujme-radio-input-btn" name="fixed_value" type="radio" id="<?= 'onetime_fixed_value_' . $amount ?>" value="<?= $amount ?>"><label class="btn btn-outline btn-block" for="<?= 'onetime_fixed_value_' . $amount ?>"><?php echo $amount . '€' ?></label></div>
                        <?php endif;
                        endforeach; ?>
                        <div class="col"><input class="darujme-radio-input-btn" name="fixed_value" type="radio" id="onetime_custom" value="custom"><label class="btn btn-outline btn-block" for="onetime_custom"><?php echo __("Vlastná suma", "kapital") ?></label></div>
                    </div>
                </section>
                <?php //periodical fixed values 
                ?>
                <section id="periodical_fixed_values" class="mb-2">
                    <div class="row gx-1 gy-1">
                    <p class="<?=$descriptive_paragraphs_classes?>">Koľko chcete prispievať?</p>
                        <?php foreach ($darujme_periodical_amounts as $key => $amount):
                            if ($amount !== "" && $amount !== "0"):
                                if ($key === 1) {
                                    $checked = ' checked="checked"';
                                } else {
                                    $checked = '';
                                } ?>
                                <div class="col"><input class="darujme-radio-input-btn" name="fixed_value" type="radio" id="<?= 'periodical_' . $amount ?>" value="<?= $amount ?>"><label class="btn btn-outline btn-block" for="<?= 'periodical_' . $amount ?>"><?php echo $amount . '€' ?></label></div>
                        <?php endif;
                        endforeach; ?>
                        <div class="col"><input class="darujme-radio-input-btn" name="fixed_value" type="radio" id="periodical_custom" value="custom"><label class="btn btn-outline btn-block" for="periodical_custom"><?php echo __("Vlastná suma", "kapital") ?></label></div>
                    </div>
                </section>
                <section class="mb-2 form-floating ff-sans" id="custom_value_row">
                    <input type="number" name="custom_value" class="form-control" placeholder="<?= __("Zadajte vlastnú sumu *", "kapital") ?>" min="1" step="any" id="custom_value">
                    <label for="custom_value"><?= __("Zadajte vlastnú sumu *", "kapital") ?></label>

                </section>
                <section id="onetime_payment_methods" class="mb-2">
                    <div class="row gx-1 gy-1">
                     <p class="<?=$descriptive_paragraphs_classes?>">Spôsob platby</p>
                        <div class="col-6 col-sm-4">
                            <input class="darujme-radio-input-btn" name="payment_method_id_temp" type="radio" id="1342d2af-a343-4e73-9f5a-7593b9978697" value="1342d2af-a343-4e73-9f5a-7593b9978697" required>
                            <label class="btn btn-outline btn-block" for="1342d2af-a343-4e73-9f5a-7593b9978697"><?php echo __("Kartou", "kapital") ?></label>
                        </div>
                        <div class="col-6 col-sm-4">
                            <input class="darujme-radio-input-btn" type="radio" name="payment_method_id_temp" id="3dcf55d1-6383-45b4-b098-dc588187b854" value="3dcf55d1-6383-45b4-b098-dc588187b854" required>
                            <label class="btn btn-outline btn-block" for="3dcf55d1-6383-45b4-b098-dc588187b854">
                                <?= __("Prevodom", "kapital") ?>
                            </label>
                        </div>
                        <div class="col-6 col-sm-4">
                            <input class="darujme-radio-input-btn" type="radio" name="payment_method_id_temp" id="payment_ib" value="payment_ib" required>
                            <label class="btn btn-outline btn-block" for="payment_ib">
                                IB
                            </label>
                        </div>
                    </div>
                </section>
                <section id="onetime_payment_methods_ib" class="mb-2">
                    <div class="row gy-1 gx-1">
                    <p class="<?=$descriptive_paragraphs_classes?>">Spôsob platby</p>
                    <div class="col-12 col-sm-4">
                        <input class="darujme-radio-input-btn" type="radio" name="payment_method_ib_id_temp" id="f2e7956e-a3f6-4bff-9e18-2ab3096a5bed" value="f2e7956e-a3f6-4bff-9e18-2ab3096a5bed" required>
                        <label class="btn btn-outline btn-block" for="f2e7956e-a3f6-4bff-9e18-2ab3096a5bed">
                            ePlatby VÚB
                        </label>
                    </div>
                    <div class="col-12 col-sm-4">
                        <input class="darujme-radio-input-btn" type="radio" name="payment_method_ib_id_temp" id="38409407-c4ec-4060-b4a1-4792f29335ad" value="38409407-c4ec-4060-b4a1-4792f29335ad" required>
                        <label class="btn btn-outline btn-block" for="38409407-c4ec-4060-b4a1-4792f29335ad">
                            TatraPay
                        </label>
                    </div>
                    <div class="col-12 col-sm-4">
                        <input class="darujme-radio-input-btn" type="radio" name="payment_method_ib_id_temp" id="c07e714c-74ed-4ac6-ab63-3898a73f1fa0" value="c07e714c-74ed-4ac6-ab63-3898a73f1fa0" required>
                        <label class="btn btn-outline btn-block" for="c07e714c-74ed-4ac6-ab63-3898a73f1fa0">
                            SporoPay
                        </label>
                    </div>
                    </div>
                </section>
                <section id="periodical_payment_methods" class="mb-2">
                    <div class="row gy-1 gx-1">
                        <p class="<?=$descriptive_paragraphs_classes?>">Spôsob platby</p>
                        <div class="col-12 col-sm-6">
                            <input class="darujme-radio-input-btn" type="radio" name="payment_method_id_temp" id="b71ff7cf-39f7-40db-8a34-e1f30292c215" value="b71ff7cf-39f7-40db-8a34-e1f30292c215" required>
                            <label class="btn btn-outline btn-block" for="b71ff7cf-39f7-40db-8a34-e1f30292c215">
                                <?= __("Kartou", "kapital") ?></label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input class="darujme-radio-input-btn" type="radio" name="payment_method_id_temp" id="f425f4af-74ce-4a9b-82d6-783c93b80f17" value="f425f4af-74ce-4a9b-82d6-783c93b80f17" required>
                            <label class="btn btn-outline btn-block" for="f425f4af-74ce-4a9b-82d6-783c93b80f17">
                                <?= __("Prevodom", "kapital") ?>
                            </label>
                        </div>
                    </div>
                </section>
                <?php //contact 
                ?>
                <section class="mb-2 ff-sans fw-normal">
                    <fieldset class="row gx-1 gy-1">
                        <p class="<?=$descriptive_paragraphs_classes?>">Kontakt</p>
                        <div class="col-12 col-sm-6 mt-2 form-floating">
                            <input type="text" class="form-control" name="first_name" id="first_name" required placeholder="<?= __("Krstné meno*", "kapital") ?>">
                            <label for="first_name"><?= __("Krstné meno *", "kapital") ?></label>
                        </div>
                        <div class="col-12 col-sm-6 mt-2 form-floating">
                            <input type="text" class="form-control" name="last_name" id="last_name" required placeholder="<?= __("Priezvisko *", "kapital") ?>">
                            <label for="last_name"><?= __("Priezvisko *", "kapital") ?></label>
                        </div>
                        <?php //email 
                        ?>
                        <div class="col-12 form-floating">
                            <input type="email" class="form-control" name="email" id="email" value required placeholder="<?= __("Email *", "kapital") ?>">
                            <label for="email"><?= __("Email *", "kapital") ?></label>
                        </div>
                        <div class="col-12">
                            <div class="form-check ms-3 mb-0">
                                <input type="checkbox" class="form-check-input" name="is_company" id="is_company">
                                <label class="form-check-label" for="is_company"><?= __("Chcem darovať ako právnická osoba", "kapital") ?></label>
                            </div>
                        </div>
                        <div class="col-12 form-floating" id="row-business_name">
                            <input type="text" class="form-control" name="company_data[business_name]" id="company_data[business_name]" placeholder="<?= __("Názov PO", "kapital") ?>">
                            <label for="company_data[business_name]"><?= __("Názov PO", "kapital") ?></label>
                        </div>
                        <div class="col-12 form-floating" id="row-business_address">
                            <input type="text" class="form-control" name="company_data[business_address]" id="company_data[business_address]" placeholder="<?= __("Adresa", "kapital") ?>">
                            <label for="company_data[business_address]"><?= __("Adresa", "kapital") ?></label>
                        </div>
                        <div class="col-12 form-floating" id="row-business_id">
                            <input type="text" class="form-control" name="company_data[business_id]" id="company_data[business_id]" placeholder="<?= __("IČO", "kapital") ?>">
                            <label for="company_data[business_id]"><?= __("IČO", "kapital") ?></label>
                        </div>
                        <div class="col-12 form-floating" id="row-business_tax_id">
                            <input type="text" class="form-control" name="company_data[tax_id]" id="company_data[tax_id]" placeholder="<?= __("DIČ", "kapital") ?>">
                            <label for="company_data[tax_id]"><?= __("DIČ", "kapital") ?></label>
                        </div>
                        <div class="col-12 form-floating" id="row-business_vat_id">
                            <input type="text" class="form-control" name="company_data[vat_id]" id="company_data[vat_id]" placeholder="<?= __("IČ DPH", "kapital") ?>">
                            <label for="company_data[vat_id]"><?= __("IČ DPH", "kapital") ?></label>
                        </div>
                        <div class="col-12" id="row-business_request_confirmation">
                            <div class="form-check ms-3">
                                <input type="checkbox" class="form-check-input" name="company_data[request_confirmation]" id="company_data[request_confirmation]">
                                <label class="form-check-label" for="company_data[request_confirmation]"><?= __("Mám záujem o potvrdenie do účtovníctva", "kapital") ?></label>
                            </div>
                        </div>
                    </fieldset>
                </section>
                <section class="ff-sans mt-4 ms-3">
                <div class="col-12">
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" name="is_anonymous" id="is_anonymous">
                        <label class="form-check-label lh-sm" for="is_anonymous"><?= __("Anonymný dar", "kapital") ?></label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" name="terms_consent" id="terms_consent" required>
                        <label class="form-check-label lh-sm" for="terms_consent">
                            <?=
                            sprintf(__('Potvrdzujem, že som bol/a informovaný/á o <a href="%s" target="_blank">spracovaní osobných údajov</a>.'), $gdpr_link)?></label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" name="gdpr_consent" id="gdpr_consent" required>
                        <label class="form-check-label lh-sm" for="gdpr_consent">
                            <?=
                            sprintf(__("Potvrdzujem, že som bol/a informovaný/á o spracovaní Osobných údajov v systéme %s"), '<a href="https://darujme.sk/pravidla-ochrany-osobnych-udajov/" target="_blank">DARUJME.sk</a>')?></label>
                    </div>
                    <p class="ff-sans ps-4 lh-sm">Potvrdením údajov súhlasíte s <a href="https://darujme.sk/pravidla-a-podmienky/" target="_blank">pravidlami</a> používania <a href="https://darujme.sk/" target="_blank">DARUJME.sk</a>.</p>

                </div>
                </section>
                <div class="px-3"><button type="submit" class="btn btn-red btn-block mt-3"><?=__("Podporiť","kapital")?></button></div>
                <small class="d-block ff-sans text-center mt-2"><?=sprintf(__("Platba realizovaná prostredníctvom %s", "kapital"), '<a href="https://darujme.sk/pravidla-ochrany-osobnych-udajov/" target="_blank">DARUJME.sk</a>',)?></small>
            </form>
        </div>
    </div>
<?php endif; ?>