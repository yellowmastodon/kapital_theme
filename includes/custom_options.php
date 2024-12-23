<?php
create_filter_option_submenu('edit.php', __('Filtre článkov', 'kapital'), 'administrator', 'post-filters', 'kapital_post_filters', ['seria', 'zaner', 'rubrika']);
create_filter_option_submenu('edit.php', __('Tematické série v hlavičke', 'kapital'), 'administrator', 'header-series', 'kapital_header_series', ['seria']);


/**
 * DARUJME OPTIONS
 */
function add_darujme_submenu_page()
{
    //create new submenu
    add_submenu_page('edit.php?post_type=inzercia', __('Nastavenie Darujme.sk', 'kapital'), __('Nastavenie Darujme.sk', 'kapital'), 'administrator', 'kapital_darujme', 'kapital_darujme_admin_page');
}

add_action('admin_menu', 'add_darujme_submenu_page');

/*
 * Register the settings
 */
function kapital_register_darujme_settings()
{
    //the third parameter is a function that will validate your input values
    register_setting('kapital_darujme_settings', 'kapital_darujme_settings', 'sanitize_darujme_options');
    add_settings_section(
        'kapital_darujme_settings',
        __('Nastavenia Darujme.sk', 'kapital'),
        '',
        'kapital_darujme'
    );

    add_settings_field(
        'campaign_active', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __('Aktivovať kampaň', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_settings',
        array(
            'type'              => 'checkbox',
            'name'              => 'campaign_active',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (empty(get_option('kapital_darujme_settings')['campaign_active'])),
            'checked'      => (!isset(get_option('kapital_darujme_settings')['campaign_active']))
                ? 0 : get_option('kapital_darujme_settings')['campaign_active'],
            'label_for'         => 'campaign_active',
        )
    );
    add_settings_field(
        'campaign_id', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __('ID kampane', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_settings',
        array(
            'type'              => 'text',
            'name'              => 'campaign_id',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['campaign_id']) ? '' : get_option('kapital_darujme_settings')['campaign_id']),
            'label_for'         => 'campaign_id',
            'description'       => __(' ID kampane nájdete na darujme.sk v záložke darovacie stránky pri vašej kampani po klinutí na "..." -> "Upraviť kampaň" -> "Rozšírené nastavenia" -> "ID kampane"', 'kapital')
        )
    );
    add_settings_field(
        'campaign_title', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __('Nadpis kampane', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_settings',
        array(
            'type'              => 'text',
            'name'              => 'campaign_title',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['campaign_title']) ? '' : get_option('kapital_darujme_settings')['campaign_title']),
            'label_for'         => 'campaign_title',
            'description'       => __('Nadpis sa zobrazí v rozbalenej verzii bloku podpory.', 'kapital')
        )
    );
    add_settings_field(
        'donation_amount_onetime', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __('Odporúčané ceny pre jednorazový príspevok', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_settings',
        array(
            'type'              => 'text',
            'name'              => 'donation_amount_onetime',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['donation_amount_onetime']) ? '' : get_option('kapital_darujme_settings')['donation_amount_onetime']),
            'label_for'         => 'donation_amount_onetime',
            'description'       => __('Číselná hodnota v eurách. Zadávajte iba nenulové celé čísla. Jednotlivé možnosti oddeľte čiarkou.', 'kapital')
        )
    );
    add_settings_field(
        'donation_amount_periodical', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __('Odporúčané ceny pre pravidelné prispievanie', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_settings',
        array(
            'type'              => 'text',
            'name'              => 'donation_amount_periodical',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['donation_amount_periodical']) ? '' : get_option('kapital_darujme_settings')['donation_amount_periodical']),
            'label_for'         => 'donation_amount_periodical',
            'description'       => __('Číselná hodnota v eurách. Zadávajte iba nenulové celé čísla. Jednotlivé možnosti oddeľte čiarkou.', 'kapital')
        )
    );
    add_settings_field(
        'darujme_short_text', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __('Krátky text kampane', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_settings',
        array(
            'type'              => 'textarea',
            'name'              => 'darujme_short_text',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['darujme_short_text']) ? '' : get_option('kapital_darujme_settings')['darujme_short_text']),
            'label_for'         => 'darujme_short_text',
            'description'       => __('Zobrazí sa v zbalenej verzii bloku podpory.', 'kapital')
        )
    );
    add_settings_field(
        'darujme_long_text', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __('Dlhý text kampane', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_settings',
        array(
            'type'              => 'textarea',
            'name'              => 'darujme_long_text',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['darujme_long_text']) ? '' : get_option('kapital_darujme_settings')['darujme_long_text']),
            'label_for'         => 'darujme_long_text',
            'description'       => __('Zobrazí sa v rozbalenej verzii bloku podpory.', 'kapital')
        )
    );
    add_settings_field(
        'darujme_kapital_gdpr_url', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __('Url Ochrany osobných údajov Kapitálu', 'kapital'),
        'kapital_darujme_input_callback',
        'kapital_darujme',
        'kapital_darujme_settings',
        array(
            'type'              => 'url',
            'name'              => 'darujme_kapital_gdpr_url',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['darujme_kapital_gdpr_url']) ? '' : get_option('kapital_darujme_settings')['darujme_kapital_gdpr_url']),
            'label_for'         => 'darujme_kapital_gdpr_url',
        )
    );
}
add_action('admin_init', 'kapital_register_darujme_settings');

// ------------------------------------------------------------------
// Callback function for our example setting
// ------------------------------------------------------------------
//
// creates a checkbox true/false option. Other types are surely possible
//

function kapital_darujme_input_callback($args)
{
    //var_dump($args);
    // Could use ob_start.
    if ($args["type"] === "textarea") {
        $html  = '';
        $html .= '<textarea rows="8" cols="60" id="' . esc_attr($args['name']) . '" 
            name="' . esc_attr($args['option_group'] . '[' . $args['name'] . ']') . '" 
            >' . $args["value"] . '</textarea>';
        if (isset($args['description'])) {
            $html .= '<p class="description">' . esc_html($args['description']) . '</p>';
        }
        echo $html;
    } elseif ($args["type"] === "checkbox") {
        $checked = '';
        $options = get_option($args['option_group']);
        $value   = (!isset($options[$args['name']]))
            ? null : $options[$args['name']];
        if ($value) {
            $checked = ' checked="checked" ';
        }
        $html  = '';
        $html .= '<input id="' . esc_attr($args['name']) . '" 
            name="' . esc_attr($args['option_group'] . '[' . $args['name'] . ']') . '" 
            type="checkbox"'  . $checked .  '"/>';
        if (isset($args['description'])) {
            $html .= '<p class="description">' . esc_html($args['description']) . '</p>';
        }
        echo $html;
    } else {
        $html  = '';
        $html .= '<input size="60" id="' . esc_attr($args['name']) . '" 
            name="' . esc_attr($args['option_group'] . '[' . $args['name'] . ']') . '" 
            type="text" value="' . $args["value"] . '"/>';
        if (isset($args['description'])) {
            $html .= '<p class="description">' . esc_html($args['description']) . '</p>';
        }
        echo $html;
    }
}




/*
 * Register the settings
 */
/* add_action('admin_init', 'kapital_register_darujme_settings');
function kapital_register_darujme_settings(){
    //this will save the option in the wp_options table as 'wpse61431_settings'
    //the third parameter is a function that will validate your input values
    register_setting('kapital_darujme_settings', 'kapital_darujme_settings', 'kapital_darujme_settings_validate');
} */

function sanitize_darujme_options($args)
{
    //$args will contain the values posted in your settings form, you can validate them as no spaces allowed, no special chars allowed or validate emails etc.
    $is_donation_one_time_numeric = true;
    $is_donation_periodical_numeric = true;
    $donation_amount_periodical = $args['donation_amount_periodical'];
    $donation_amount_periodical = explode(',', $donation_amount_periodical);
    $donation_amount_periodical = array_map(function ($item) {
        $item = trim($item);
        return $item;
    }, $donation_amount_periodical);
    foreach ($donation_amount_periodical as $item) {
        if (!is_numeric($item) || $item === "0") {
            $is_donation_periodical_numeric = false;
        }
    }

    $donation_amount_onetime = $args['donation_amount_onetime'];
    $donation_amount_onetime = explode(',', $donation_amount_onetime);
    $donation_amount_onetime = array_map(function ($item) {
        $item = trim($item);
        return $item;
    }, $donation_amount_onetime);
    foreach ($donation_amount_onetime as $item) {
        if (!is_numeric($item) || $item === "0") {
            $is_donation_one_time_numeric = false;
        }
    }
    if (!isset($args['donation_amount_onetime']) || !$is_donation_one_time_numeric) {
        //add a settings error because the email is invalid and make the form field blank, so that the user can enter again
        $args['donation_amount_onetime'] = '';
        add_settings_error('kapital_darujme_settings', 'kapital_darujme_settings_invalid_donation_amount_onetime', 'Pole "Odporúčané ceny pre jendorazový príspevok" môže obsahovať iba nenulové celé čísla oddelené čiarkou.  Prednastavená bude vždy druhá hodnota.', $type = 'error');
    }
    if (!isset($args['donation_amount_periodical']) || !$is_donation_periodical_numeric) {
        //add a settings error because the email is invalid and make the form field blank, so that the user can enter again
        $args['donation_amount_periodical'] = '';
        add_settings_error('kapital_darujme_settings', 'kapital_darujme_settings_invalid_donation_amount_onetime', 'Pole "Odporúčané ceny pre pravidelné prispievanie" môže obsahovať iba nenulové celé čísla oddelené čiarkou. Prednastavená bude vždy druhá hodnota.', $type = 'error');
    }
    //make sure you return the args
    return $args;
}

//Display the validation errors and update messages
/*
 * Admin notices
 */
add_action('admin_notices', 'kapital_admin_notices');
function kapital_admin_notices()
{
    settings_errors();
}

//The markup for your plugin settings page
function kapital_darujme_admin_page()
{ ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('kapital_darujme_settings');
            do_settings_sections('kapital_darujme');
            submit_button(__('Uložiť nastavenia', 'kapital')); ?>

        </form>
    </div>
    <script>

    </script>
<?php }

function add_podcast_submenu_page()
{
    //create new submenu
    add_submenu_page('edit.php?post_type=podcast', __('Popiska archívu podcastov', 'kapital'), __('Popiska archívu podcastov', 'kapital'), 'administrator', 'podcast_description', 'render_podcast_description_page');
    //call register settings function
}
add_action('admin_menu', 'add_podcast_submenu_page');
add_action('admin_init', function () {
    register_setting(
        'podcast_description',
        'podcast_description',
        array(
            'type' => 'string',
            'default' => '',
        )
    );
});
function render_podcast_description_page()
{
    // Get the current value of the option
?>
    <div class="wrap">
        <h1><?php echo __('Popiska podcastov', 'kapital') ?></h1>

        <form method="post" action="options.php">
            <?php settings_fields('podcast_description'); ?>
            <?php do_settings_sections('podcast_description');
            		wp_enqueue_editor();
                    wp_enqueue_media();
            ?>
            <?php $podcast_description = get_option('podcast_description', ''); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?=__('Popiska podcastov', 'kapital')?></th>
                    <td>
                    <textarea id="podcast_description_textarea" cols="100" rows="10" name="podcast_description"><?=$podcast_description?></textarea>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>

        </form>
    </div>
    <script id="term_description_tinymce">
		jQuery(document).ready(function($) {
			wp.editor.initialize('podcast_description_textarea', {
				tinymce: {
					// customizable options for TinyMCE
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
