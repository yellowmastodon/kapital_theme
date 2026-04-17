<?php

add_action('init', function () {
    create_filter_option_submenu('edit.php', __('Filtre článkov', 'kapital'), 'administrator', 'post-filters', 'kapital_post_filters', ['seria', 'zaner', 'rubrika']);
    create_filter_option_submenu('edit.php', __('Tematické série v hlavičke', 'kapital'), 'administrator', 'header-series', 'kapital_header_series', ['seria']);
});


// ============================================================
// DARUJME OPTIONS
// ============================================================

add_action('admin_menu', 'add_darujme_submenu_page');

function add_darujme_submenu_page()
{
    add_submenu_page(
        'edit.php?post_type=inzercia',
        __('Nastavenie Darujme.sk', 'kapital'),
        __('Nastavenie Darujme.sk', 'kapital'),
        'administrator',
        'kapital_darujme',
        'kapital_darujme_admin_page'
    );
}

add_action('admin_init', 'kapital_register_darujme_settings');

function kapital_register_darujme_settings()
{
    register_setting('kapital_darujme_settings', 'kapital_darujme_settings', 'sanitize_darujme_options');

    // ------------------------------------------------------------
    // Main section
    // ------------------------------------------------------------
    add_settings_section('kapital_darujme_settings', __('Nastavenia Darujme.sk', 'kapital'), '', 'kapital_darujme');

    add_settings_field(
        'campaign_active',
        __('Aktivovať kampaň', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_settings',
        [
            'type'         => 'checkbox',
            'name'         => 'campaign_active',
            'option_group' => 'kapital_darujme_settings',
            'value'        => (empty(get_option('kapital_darujme_settings')['campaign_active'])),
            'checked'      => (!isset(get_option('kapital_darujme_settings')['campaign_active']))
                                ? 0 : get_option('kapital_darujme_settings')['campaign_active'],
            'label_for'    => 'campaign_active',
        ]
    );

    add_settings_field(
        'campaign_id',
        __('ID kampane', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_settings',
        [
            'type'         => 'text',
            'name'         => 'campaign_id',
            'option_group' => 'kapital_darujme_settings',
            'value'        => get_option('kapital_darujme_settings')['campaign_id'] ?? '',
            'label_for'    => 'campaign_id',
            'description'  => __('ID kampane nájdete na darujme.sk v záložke darovacie stránky pri vašej kampani po klinutí na "..." -> "Upraviť kampaň" -> "Rozšírené nastavenia" -> "ID kampane"', 'kapital'),
        ]
    );

    add_settings_field(
        'donation_amount_onetime',
        __('Odporúčané ceny pre jednorazový príspevok', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_settings',
        [
            'type'         => 'text',
            'name'         => 'donation_amount_onetime',
            'option_group' => 'kapital_darujme_settings',
            'value'        => get_option('kapital_darujme_settings')['donation_amount_onetime'] ?? '',
            'label_for'    => 'donation_amount_onetime',
            'description'  => __('Číselná hodnota v eurách. Zadávajte iba nenulové celé čísla. Jednotlivé možnosti oddeľte čiarkou.', 'kapital'),
        ]
    );

    add_settings_field(
        'donation_amount_periodical',
        __('Odporúčané ceny pre pravidelné prispievanie', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_settings',
        [
            'type'         => 'text',
            'name'         => 'donation_amount_periodical',
            'option_group' => 'kapital_darujme_settings',
            'value'        => get_option('kapital_darujme_settings')['donation_amount_periodical'] ?? '',
            'label_for'    => 'donation_amount_periodical',
            'description'  => __('Číselná hodnota v eurách. Zadávajte iba nenulové celé čísla. Jednotlivé možnosti oddeľte čiarkou.', 'kapital'),
        ]
    );

    // ------------------------------------------------------------
    // Collapsed banner section
    // ------------------------------------------------------------
    add_settings_section('kapital_darujme_collapsed_section', __('Zbalený formulár', 'kapital'), null, 'kapital_darujme');



    /* Selector that drives the conditional display of yes/no fields below */
    add_settings_field(
        'banner_mode',
        __('Typ bannera', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_collapsed_section',
        [
            'type'         => 'select',
            'name'         => 'banner_mode',
            'option_group' => 'kapital_darujme_settings',
            'value'        => get_option('kapital_darujme_settings')['banner_mode'] ?? 'default',
            'label_for'    => 'banner_mode',
            'options'      => [
                'default' => __('Štandardný banner', 'kapital'),
                'yesno'   => __('Použiť áno/nie banner', 'kapital'),
            ],
        ]
    );

    /*
     * campaign_title_short and darujme_short_text carry two extra args:
     *   label_default — label shown in standard mode
     *   label_yesno   — label shown when banner_mode === 'yesno'
     * The JS uses these to swap the <th> text without a page reload.
     */
    add_settings_field(
        'campaign_title_short',
        __('Nadpis kampane', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_collapsed_section',
        [
            'type'          => 'text',
            'name'          => 'campaign_title_short',
            'option_group'  => 'kapital_darujme_settings',
            'value'         => get_option('kapital_darujme_settings')['campaign_title_short'] ?? '',
            'label_for'     => 'campaign_title_short',
            'description'   => __('Nadpis sa zobrazí v zbalenej verzii bloku podpory.', 'kapital'),
            'label_default' => __('Nadpis kampane', 'kapital'),
            'label_yesno'   => __('Nadpis pri odpovedi „áno"', 'kapital'),
            'row_class'     => 'kapital-field-campaign-title-short',
        ]
    );

    /* Hidden by JS when banner_mode === 'yesno' — replaced by campaign_title_short_no */
    add_settings_field(
        'campaign_title_short_alt',
        __('Alternatívny nadpis', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_collapsed_section',
        [
            'type'         => 'text',
            'name'         => 'campaign_title_short_alt',
            'option_group' => 'kapital_darujme_settings',
            'value'        => get_option('kapital_darujme_settings')['campaign_title_short_alt'] ?? '',
            'label_for'    => 'campaign_title_short_alt',
            'description'  => __('Nadpis sa zobrazí v zbalenej verzii bloku podpory, mimo článku.', 'kapital'),
            'row_class'    => 'kapital-field-campaign-title-short-alt',
        ]
    );

    /* Visible only when banner_mode === 'yesno' */
    add_settings_field(
        'campaign_title_short_no',
        __('Nadpis pri odpovedi „nie"', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_collapsed_section',
        [
            'type'         => 'text',
            'name'         => 'campaign_title_short_no',
            'option_group' => 'kapital_darujme_settings',
            'value'        => get_option('kapital_darujme_settings')['campaign_title_short_no'] ?? '',
            'label_for'    => 'campaign_title_short_no',
            'description'  => __('Zobrazí sa po kliknutí na odpoveď „nie". Odpoveď „áno" reusuje pole Nadpis kampane.', 'kapital'),
            'row_class'    => 'kapital-field-yesno-only',
        ]
    );


    /* Repeater for yes/no button label pairs — visible only when banner_mode === 'yesno' */
    add_settings_field(
        'answers_repeater',
        __('Odpovede (áno/nie)', 'kapital'),
        'kapital_darujme_answers_repeater_callback',
        'kapital_darujme',
        'kapital_darujme_collapsed_section',
        [
            'option_group' => 'kapital_darujme_settings',
            'row_class'    => 'kapital-field-yesno-only',
        ]
    );

        add_settings_field(
        'darujme_short_text',
        __('Text kampane', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_collapsed_section',
        [
            'type'          => 'textarea',
            'name'          => 'darujme_short_text',
            'option_group'  => 'kapital_darujme_settings',
            'value'         => get_option('kapital_darujme_settings')['darujme_short_text'] ?? '',
            'label_for'     => 'darujme_short_text',
            'description'   => __('Zobrazí sa v zbalenej verzii bloku podpory.', 'kapital'),
            'label_default' => __('Text kampane', 'kapital'),
            'label_yesno'   => __('Text za tlačidlami', 'kapital'),
            'row_class'     => 'kapital-field-darujme-short-text',
        ]
    );


    // ------------------------------------------------------------
    // Expanded banner section
    // ------------------------------------------------------------
    add_settings_section('kapital_darujme_expanded_section', __('Rozbalený formulár', 'kapital'), null, 'kapital_darujme');

    add_settings_field(
        'campaign_title',
        __('Nadpis kampane', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_expanded_section',
        [
            'type'         => 'text',
            'name'         => 'campaign_title',
            'option_group' => 'kapital_darujme_settings',
            'value'        => get_option('kapital_darujme_settings')['campaign_title'] ?? '',
            'label_for'    => 'campaign_title',
            'description'  => __('Nadpis sa zobrazí v rozbalenej verzii bloku podpory.', 'kapital'),
        ]
    );

    add_settings_field(
        'darujme_long_text',
        __('Rozbalený formulár: Text kampane', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_expanded_section',
        [
            'type'         => 'textarea',
            'name'         => 'darujme_long_text',
            'option_group' => 'kapital_darujme_settings',
            'value'        => get_option('kapital_darujme_settings')['darujme_long_text'] ?? '',
            'label_for'    => 'darujme_long_text',
            'description'  => __('Zobrazí sa v rozbalenej verzii bloku podpory.', 'kapital'),
        ]
    );

    add_settings_field(
        'darujme_kapital_gdpr_url',
        __('Url Ochrany osobných údajov Kapitálu', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_expanded_section',
        [
            'type'         => 'url',
            'name'         => 'darujme_kapital_gdpr_url',
            'option_group' => 'kapital_darujme_settings',
            'value'        => get_option('kapital_darujme_settings')['darujme_kapital_gdpr_url'] ?? '',
            'label_for'    => 'darujme_kapital_gdpr_url',
        ]
    );

    // ------------------------------------------------------------
    // Modal banners section
    // ------------------------------------------------------------
    add_settings_section('kapital_darujme_modal_section', __('Vyskakovací banner', 'kapital'), 'kapital_darujme_modal_repeater_callback', 'kapital_darujme');
}


/**
 * Renders a single settings field.
 *
 * Supported types: text, url, textarea, checkbox, select.
 *
 * Extra args (all optional):
 *   row_class     — CSS class added to the parent <tr> via a hidden marker span.
 *   label_default — <th> text used in standard banner mode.
 *   label_yesno   — <th> text used when banner_mode === 'yesno'.
 *   options       — key/value pairs for type="select".
 *   description   — helper text rendered below the input.
 *
 * @param array $args Field arguments passed from add_settings_field().
 */
function kapital_darujme_input_callback($args)
{
    $row_class     = $args['row_class']     ?? '';
    $label_default = $args['label_default'] ?? '';
    $label_yesno   = $args['label_yesno']   ?? '';

    /*
     * Hidden marker span — the JS walks up to the parent <tr> from here
     * to attach the row class and label-swap data attributes.
     */
    if ($row_class || $label_default || $label_yesno) {
        printf(
            '<span class="kapital-row-marker" data-row-class="%s" data-label-default="%s" data-label-yesno="%s"></span>',
            esc_attr($row_class),
            esc_attr($label_default),
            esc_attr($label_yesno)
        );
    }

    $field_name = esc_attr($args['option_group'] . '[' . $args['name'] . ']');
    $field_id   = esc_attr($args['name']);

    switch ($args['type']) {
        case 'textarea':
            printf(
                '<textarea rows="8" cols="60" id="%s" name="%s">%s</textarea>',
                $field_id,
                $field_name,
                esc_textarea($args['value'])
            );
            break;

        case 'checkbox':
            $options = get_option($args['option_group']);
            $checked = !empty($options[$args['name']]) ? ' checked="checked"' : '';
            printf(
                '<input id="%s" name="%s" type="checkbox"%s/>',
                $field_id,
                $field_name,
                $checked
            );
            break;

        case 'select':
            printf('<select id="%s" name="%s">', $field_id, $field_name);
            foreach ($args['options'] as $val => $label) {
                printf(
                    '<option value="%s"%s>%s</option>',
                    esc_attr($val),
                    selected($args['value'], $val, false),
                    esc_html($label)
                );
            }
            echo '</select>';
            break;

        default:
            // text, url, etc.
            printf(
                '<input size="60" id="%s" name="%s" type="%s" value="%s"/>',
                $field_id,
                $field_name,
                esc_attr($args['type']),
                esc_attr($args['value'])
            );
            break;
    }

    if (!empty($args['description'])) {
        printf('<p class="description">%s</p>', esc_html($args['description']));
    }
}


/**
 * Renders the yes/no answers repeater table.
 *
 * Stored as two parallel arrays:
 *   kapital_darujme_settings[answer_yes][]
 *   kapital_darujme_settings[answer_no][]
 *
 * @param array $args Field arguments passed from add_settings_field().
 */
function kapital_darujme_answers_repeater_callback($args)
{
    $options    = get_option($args['option_group'], []);
    $answer_yes = $options['answer_yes'] ?? [];
    $answer_no  = $options['answer_no'] ?? [];
    $count      = max(count($answer_yes), count($answer_no), 1);
    $og         = esc_attr($args['option_group']);

    printf(
        '<span class="kapital-row-marker" data-row-class="%s"></span>',
        esc_attr($args['row_class'] ?? '')
    );
    ?>
    <div id="kapital-answers-repeater">
        <table class="widefat">
            <thead>
                <tr>
                    <th><?php esc_html_e('Odpoveď ÁNO', 'kapital'); ?></th>
                    <th><?php esc_html_e('Odpoveď NIE', 'kapital'); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="kapital-answers-rows">
                <?php for ($i = 0; $i < $count; $i++) : ?>
                    <tr class="kapital-answer-row">
                        <td>
                            <input type="text"
                                name="<?php echo $og; ?>[answer_yes][]"
                                value="<?php echo esc_attr($answer_yes[$i] ?? ''); ?>" />
                        </td>
                        <td>
                            <input type="text"
                                name="<?php echo $og; ?>[answer_no][]"
                                value="<?php echo esc_attr($answer_no[$i] ?? ''); ?>" />
                        </td>
                        <td>
                            <button type="button" class="button kapital-remove-row"
                                <?php echo ($i === 0 && $count === 1) ? 'disabled' : ''; ?>>
                                &times;
                            </button>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
        <button type="button" id="kapital-add-answer-row" class="button button-secondary">
            <?php esc_html_e('+ Pridať odpovede', 'kapital'); ?>
        </button>
    </div>
    <?php
}


/**
 * Renders the modal banners repeater.
 * Used as a section callback (not a field callback).
 *
 * Stored as parallel arrays:
 *   kapital_darujme_settings[modal_banner_title][]
 *   kapital_darujme_settings[modal_banner_text][]
 *   etc.
 *
 * @param string $section_id The section ID (passed by add_settings_section).
 */
function kapital_darujme_modal_repeater_callback($section_id = '')
{
    $option_group = 'kapital_darujme_settings';
    $options = get_option($option_group, []);
    $modal_active = $options['modal_banner_active'] ?? false;
    $titles = $options['modal_banner_title'] ?? [];
    $texts = $options['modal_banner_text'] ?? [];
    $btns_support = $options['modal_banner_btn_support'] ?? [];
    $btns_support_url = $options['modal_banner_btn_support_url'] ?? [];
    $btns_later = $options['modal_banner_btn_later'] ?? [];
    $btns_supporting = $options['modal_banner_btn_supporting'] ?? [];
    $count = max(count($titles), count($texts), count($btns_support), count($btns_support_url), count($btns_later), count($btns_supporting), 1);
    $og = esc_attr($option_group);
    ?>
    <table class="form-table kapital-modal-banner-active-toggle" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><label class="kapital-modal-banner-active-label" for="modal_banner_active"><?php esc_html_e('Aktivovať vyskakovací banner', 'kapital'); ?></label></th>
                <td><input type="checkbox" id="modal_banner_active" name="<?php echo $og; ?>[modal_banner_active]"<?= $modal_active ? ' checked="checked"' : '' ?> /></td>
            </tr>
        </tbody>
    </table>
    <div id="kapital-modal-banners-repeater">
        <?php for ($i = 0; $i < $count; $i++) : ?>
            <div class="kapital-modal-banner-item">
                <div class="kapital-modal-banner-version-label">
                    <?php printf(esc_html__('Verzia %d', 'kapital'), $i + 1); ?>
                </div>

                <label>
                    <span><?php esc_html_e('Nadpis', 'kapital'); ?></span>
                    <textarea rows="2" cols="60" name="<?php echo $og; ?>[modal_banner_title][]"><?php echo esc_textarea($titles[$i] ?? ''); ?></textarea>
                </label>

                <label>
                    <span><?php esc_html_e('Text', 'kapital'); ?></span>
                    <textarea rows="4" cols="60" name="<?php echo $og; ?>[modal_banner_text][]"><?php echo esc_textarea($texts[$i] ?? ''); ?></textarea>
                </label>

                <label>
                    <span><?php esc_html_e('Tlačidlo "Podporiť"', 'kapital'); ?></span>
                    <textarea rows="2" cols="60" name="<?php echo $og; ?>[modal_banner_btn_support][]"><?php echo esc_textarea($btns_support[$i] ?? ''); ?></textarea>
                </label>

                <label>
                    <span><?php esc_html_e('Link tlačidla "Podporiť"', 'kapital'); ?></span>
                    <input type="url" size="60" name="<?php echo $og; ?>[modal_banner_btn_support_url][]" value="<?php echo esc_attr($btns_support_url[$i] ?? ''); ?>" />
                </label>

                <label>
                    <span><?php esc_html_e('Tlačidlo "Neskôr"', 'kapital'); ?></span>
                    <textarea rows="2" cols="60" name="<?php echo $og; ?>[modal_banner_btn_later][]"><?php echo esc_textarea($btns_later[$i] ?? ''); ?></textarea>
                </label>

                <label>
                    <span><?php esc_html_e('Tlačidlo "Už podporujem"', 'kapital'); ?></span>
                    <textarea rows="2" cols="60" name="<?php echo $og; ?>[modal_banner_btn_supporting][]"><?php echo esc_textarea($btns_supporting[$i] ?? ''); ?></textarea>
                </label>

                <button type="button" class="button button-secondary kapital-remove-modal-row" <?php echo ($i === 0 && $count === 1) ? 'disabled' : ''; ?>>
                    &times; <?php esc_html_e('Odstrániť verziu', 'kapital'); ?>
                </button>
            </div>
        <?php endfor; ?>
    </div>
    <button type="button" id="kapital-add-modal-banner-row" class="button button-secondary">
        <?php esc_html_e('+ Pridať verziu vyskakovacieho banneru', 'kapital'); ?>
    </button>
    <?php
}


/**
 * Sanitizes and validates all Darujme settings before saving.
 *
 * @param  array $args Raw values from the settings form.
 * @return array Sanitized values.
 */
function sanitize_darujme_options($args)
{
    // Validate comma-separated non-zero integers for donation amounts
    foreach (['donation_amount_onetime', 'donation_amount_periodical'] as $field) {
        $valid  = true;
        $values = array_map('trim', explode(',', $args[$field] ?? ''));
        foreach ($values as $v) {
            if (!is_numeric($v) || $v === '0') {
                $valid = false;
                break;
            }
        }
        if (!$valid) {
            $args[$field] = '';
            $label = $field === 'donation_amount_onetime'
                ? 'Odporúčané ceny pre jednorazový príspevok'
                : 'Odporúčané ceny pre pravidelné prispievanie';
            add_settings_error(
                'kapital_darujme_settings',
                'invalid_' . $field,
                'Pole "' . $label . '" môže obsahovať iba nenulové celé čísla oddelené čiarkou. Prednastavená bude vždy druhá hodnota.',
                'error'
            );
        }
    }

    // banner_mode: only allow known values
    $args['banner_mode'] = (($args['banner_mode'] ?? '') === 'yesno') ? 'yesno' : 'default';

    // Normalize checkbox values
    $args['campaign_active'] = !empty($args['campaign_active']) ? true : false;
    $args['modal_banner_active'] = !empty($args['modal_banner_active']) ? true : false;

    // Title shown after clicking "no"
    $args['campaign_title_short_no'] = sanitize_text_field($args['campaign_title_short_no'] ?? '');

    // Repeater: sanitize and strip fully-empty pairs
    $answer_yes = (array) ($args['answer_yes'] ?? []);
    $answer_no  = (array) ($args['answer_no']  ?? []);
    $clean_yes  = [];
    $clean_no   = [];

    for ($i = 0, $n = max(count($answer_yes), count($answer_no)); $i < $n; $i++) {
        $yes = sanitize_text_field($answer_yes[$i] ?? '');
        $no  = sanitize_text_field($answer_no[$i]  ?? '');
        if ($yes !== '' || $no !== '') {
            $clean_yes[] = $yes;
            $clean_no[]  = $no;
        }
    }

    $args['answer_yes'] = $clean_yes;
    $args['answer_no']  = $clean_no;
    // Modal banners repeater: sanitize and strip fully-empty sets
    $modal_title = (array) ($args['modal_banner_title'] ?? []);
    $modal_text = (array) ($args['modal_banner_text'] ?? []);
    $modal_btn_support = (array) ($args['modal_banner_btn_support'] ?? []);
    $modal_btn_support_url = (array) ($args['modal_banner_btn_support_url'] ?? []);
    $modal_btn_later = (array) ($args['modal_banner_btn_later'] ?? []);
    $modal_btn_supporting = (array) ($args['modal_banner_btn_supporting'] ?? []);
    $clean_title = [];
    $clean_text = [];
    $clean_btn_support = [];
    $clean_btn_support_url = [];
    $clean_btn_later = [];
    $clean_btn_supporting = [];
    $n = max(count($modal_title), count($modal_text), count($modal_btn_support), count($modal_btn_support_url), count($modal_btn_later), count($modal_btn_supporting));
    for ($i = 0; $i < $n; $i++) {
        $title = sanitize_textarea_field($modal_title[$i] ?? '');
        $text = sanitize_textarea_field($modal_text[$i] ?? '');
        $btn_support = sanitize_textarea_field($modal_btn_support[$i] ?? '');
        $btn_support_url = esc_url_raw($modal_btn_support_url[$i] ?? '');
        $btn_later = sanitize_textarea_field($modal_btn_later[$i] ?? '');
        $btn_supporting = sanitize_textarea_field($modal_btn_supporting[$i] ?? '');
        if ($title !== '' || $text !== '' || $btn_support !== '' || $btn_support_url !== '' || $btn_later !== '' || $btn_supporting !== '') {
            $clean_title[] = $title;
            $clean_text[] = $text;
            $clean_btn_support[] = $btn_support;
            $clean_btn_support_url[] = $btn_support_url;
            $clean_btn_later[] = $btn_later;
            $clean_btn_supporting[] = $btn_supporting;
        }
    }
    $args['modal_banner_title'] = $clean_title;
    $args['modal_banner_text'] = $clean_text;
    $args['modal_banner_btn_support'] = $clean_btn_support;
    $args['modal_banner_btn_support_url'] = $clean_btn_support_url;
    $args['modal_banner_btn_later'] = $clean_btn_later;
    $args['modal_banner_btn_supporting'] = $clean_btn_supporting;
    return $args;
}


add_action('admin_notices', 'kapital_admin_notices');

function kapital_admin_notices()
{
    settings_errors();
}


function kapital_darujme_admin_page()
{
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('kapital_darujme_settings');
            do_settings_sections('kapital_darujme');
            submit_button(__('Uložiť nastavenia', 'kapital'));
            ?>
        </form>
    </div>

    <style>
        h2:not(:first-child) {
            margin-top: 15px;
            padding-top: 30px;
            border-top: solid 1px #ccc;
        }
        /* Applied by JS to rows that should be hidden in the current banner mode */
        .kapital-row-hidden {
            display: none !important;
        }
        #kapital-answers-repeater .widefat {
            border-collapse: collapse;
        }

        #kapital-answers-repeater .widefat th,
        #kapital-answers-repeater .widefat td {
            padding: 8px;
            text-align: left;
        }
        #kapital-answers-repeater table, .kapital-modal-banner-item{
            margin-bottom: 12px;
            width: fit-content;
        }

        .kapital-modal-banner-version-label{
            font-weight: bold;
            font-size: 14px;
            border-bottom: 1px solid #c3c4c7;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .kapital-modal-banner-item{
            background: white;
            padding: 8px;
            border: solid 1px #ccc;
        }






        #kapital-modal-banners-repeater label{
            display: table-row !important;
        }
        #kapital-modal-banners-repeater label span{
            display: table-cell;
            vertical-align: top;
            text-align: left;
            padding: 20px 10px 20px 0;
            width: 200px;
            line-height: 1.3;
            font-weight: 600;
        }

        #kapital-modal-banners-repeater label textarea, #kapital-modal-banners-repeater label input[type="text"], #kapital-modal-banners-repeater label input[type="url"]{
            display: table-cell;
            margin: 8px
        }

        
        


    </style>

    <script>
    (function ($) {

        // ----------------------------------------------------------
        // On load: read the hidden marker spans and push row-class
        // and label-swap data up onto the parent <tr>
        // ----------------------------------------------------------
        $('.kapital-row-marker').each(function () {
            var $tr = $(this).closest('tr');
            var rc  = $(this).data('row-class');
            var ld  = $(this).data('label-default');
            var ly  = $(this).data('label-yesno');
            if (rc) $tr.addClass(rc);
            if (ld) $tr.attr('data-label-default', ld);
            if (ly) $tr.attr('data-label-yesno',   ly);
        });

        // ----------------------------------------------------------
        // Show/hide rows and swap <th> labels based on banner mode
        // ----------------------------------------------------------
        function applyBannerMode(mode) {
            var isYesNo = (mode === 'yesno');

            // Fields only relevant to yes/no mode
            $('.kapital-field-yesno-only')
                .toggleClass('kapital-row-hidden', !isYesNo);

            // Alt title is replaced by campaign_title_short_no in yes/no mode
            $('.kapital-field-campaign-title-short-alt')
                .toggleClass('kapital-row-hidden', isYesNo);

            // Swap <th> text for fields whose label changes meaning
            var labelAttr = isYesNo ? 'data-label-yesno' : 'data-label-default';
            $('.kapital-field-campaign-title-short, .kapital-field-darujme-short-text')
                .each(function () {
                    var newLabel = $(this).attr(labelAttr);
                    if (!newLabel) return;
                    var $lbl = $(this).find('th label');
                    if ($lbl.length) {
                        $lbl.text(newLabel);
                    } else {
                        $(this).find('th').text(newLabel);
                    }
                });
        }

        $('#banner_mode').on('change', function () {
            applyBannerMode($(this).val());
        });

        // Run once on page load to reflect saved value
        applyBannerMode($('#banner_mode').val());

        // ----------------------------------------------------------
        // Repeater: add / remove yes/no answer pairs
        // ----------------------------------------------------------
        var og = 'kapital_darujme_settings';

        function syncRemoveButtons() {
            var rows = $('#kapital-answers-rows .kapital-answer-row');
            rows.find('.kapital-remove-row').prop('disabled', rows.length === 1);
        }

        $('#kapital-add-answer-row').on('click', function () {
            $('#kapital-answers-rows').append(
                '<tr class="kapital-answer-row">' +
                    '<td><input type="text" name="' + og + '[answer_yes][]" value=""/></td>' +
                    '<td><input type="text" name="' + og + '[answer_no][]"  value=""/></td>' +
                    '<td><button type="button" class="button kapital-remove-row">&times;</button></td>' +
                '</tr>'
            );
            syncRemoveButtons();
        });

        $(document).on('click', '.kapital-remove-row', function () {
            $(this).closest('.kapital-answer-row').remove();
            syncRemoveButtons();
        });

        syncRemoveButtons();

        // ----------------------------------------------------------
        // Repeater: add / remove modal banner versions
        // ----------------------------------------------------------
        function syncRemoveModalButtons() {
            var rows = $('#kapital-modal-banners-repeater .kapital-modal-banner-item');
            rows.find('.kapital-remove-modal-row').prop('disabled', rows.length === 1);
        }

        $('#kapital-add-modal-banner-row').on('click', function () {
            var $first = $('#kapital-modal-banners-repeater .kapital-modal-banner-item').first();
            if (!$first.length) {
                return;
            }

            var $clone = $first.clone(false);
            $clone.find('textarea').val('');
            $clone.find('[id]').removeAttr('id');
            $clone.find('.kapital-remove-modal-row').prop('disabled', false);
            $('#kapital-modal-banners-repeater').append($clone);
            syncRemoveModalButtons();
        });

        $(document).on('click', '.kapital-remove-modal-row', function () {
            $(this).closest('.kapital-modal-banner-item').remove();
            syncRemoveModalButtons();
        });

        syncRemoveModalButtons();

    })(jQuery);
    </script>
    <?php
}


// ============================================================
// PODCAST OPTIONS
// ============================================================

add_action('admin_menu', 'add_podcast_submenu_page');

function add_podcast_submenu_page()
{
    add_submenu_page(
        'edit.php?post_type=podcast',
        __('Popiska archívu podcastov', 'kapital'),
        __('Popiska archívu podcastov', 'kapital'),
        'administrator',
        'podcast_description',
        'render_podcast_description_page'
    );
}

add_action('admin_init', function () {
    register_setting('podcast_description', 'podcast_description', [
        'type'    => 'string',
        'default' => '',
    ]);
});

function render_podcast_description_page()
{
    ?>
    <div class="wrap">
        <h1><?php echo __('Popiska podcastov', 'kapital'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('podcast_description');
            do_settings_sections('podcast_description');
            wp_enqueue_editor();
            wp_enqueue_media();
            ?>
            <?php $podcast_description = get_option('podcast_description', ''); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?= __('Popiska podcastov', 'kapital') ?></th>
                    <td>
                        <textarea id="podcast_description_textarea" cols="100" rows="10" name="podcast_description"><?= $podcast_description ?></textarea>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <script id="term_description_tinymce">
        jQuery(document).ready(function ($) {
            wp.editor.initialize('podcast_description_textarea', {
                tinymce: {
                    toolbar1: 'formatselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
                    plugins: 'link,lists,textcolor,colorpicker',
                    menubar: false,
                    statusbar: false,
                },
                quicktags: true,
                mediaButtons: false,
            });
        });
    </script>
    <?php
}
