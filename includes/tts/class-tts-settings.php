<?php

/**
 * ElevenLabs Settings
 */

class TTS_Settings
{

    /** @var string Option prefix */
    const OPTION_PREFIX = 'kptl_tts_';

    /** @var string Option group name */
    private static $option_group;

    /** @var string Option name in database */
    private static $option_name;

    /** @var array Text fields */
    private static $text_fields;

    /** @var string|null cached api key, so no need to call options each time */
    private static $api_key = null;

    /** @var bool breaks the external api verification process during option render if api key invalid */
    private static $continue_verify = true;

    /**
     * Initialize - Hook into WordPress
     */
    public static function init()
    {
        self::$option_group = self::OPTION_PREFIX . 'options';
        self::$option_name =  self::OPTION_PREFIX . 'settings';
        add_action('admin_menu', array(__CLASS__, 'add_theme_page'));
        add_action('admin_init', array(__CLASS__, 'register_settings'));
    }

    /**
     * Add theme options page to admin menu
     */
    public static function add_theme_page()
    {
        add_menu_page(
            __('Nastavenia integrácie s ElevenLabs', 'kapital'),
            __('Text to speech', 'kapital'),
            'manage_options',
            'kapital-tts',
            array(__CLASS__, 'render_options_page'),
            'dashicons-microphone', // Icon (optional)
            22                         // Position (optional)
        );
    }

    /**
     * Register settings, sections, and fields
     */
    public static function register_settings()
    {

        self::$text_fields  = array(
            'api_key' => [
                'title' => __('ElevenLabs API key', 'kapital'),
                'placeholder' => __('Vložte API kľúč', 'kapital'),
                'description' => __('API kľúč nájdete <a href="https://elevenlabs.io/app/developers/api-keys" target="_blank">tu</a>.', 'kapital'),
                'verify' => 'api_key'
            ],
            'voice_id' => [
                'title' => __('Voice ID (slovenčina)', 'kapital'),
                'description' => '',
                'placeholder' => __('Vlože ID hlasu', 'kapital'),
                'verify' => 'voice_id'
            ],
            'voice_id_fallback' => [
                'title' => __('Voice ID (ostatné jazyky)', 'kapital'),
                'placeholder' => __('Vlože ID hlasu', 'kapital'),
                'description' => __('Voice clone môže byť nespoľahlivý pre iné jazyky. Nechajte prázdne ak sa nepoužíva.', 'kapital'),
                'verify' => 'voice_id'

            ]
        );

        register_setting(
            self::$option_group,
            self::$option_name,
            array(__CLASS__, 'sanitize_options')
        );

        add_settings_section(
            'general_section',
            __('Nastavenia', 'kapital'),
            array(__CLASS__, 'section_callback'),
            self::$option_group
        );

        foreach (self::$text_fields as $field_id => $value) {

            add_settings_field(
                $field_id,
                $value['title'],
                array(__CLASS__, 'text_field_callback'),
                self::$option_group,
                'general_section',
                array(
                    'id' => $field_id,
                    'placeholder' => $value['placeholder'],
                    'description' => $value['description'],
                    'verify' => $value['verify']
                )
            );
        }

         add_settings_field(
            'credits_display',
            __('Počet kreditov', 'kapital'),
            array(__CLASS__, 'credits_field_callback'),
            self::$option_group,
            'general_section',
            array(
                'id' => 'credits_display'
            )
        );
    }

    public static function section_callback($args){
        return;
    }

    /**
     * Text field callback
     */
    public static function text_field_callback($args)
    {
        $value = self::get_option($args['id']);
        $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';

        if (self::$continue_verify && isset($args['verify'])) {
            switch ($args['verify']) {
                case 'api_key':
                    $check = TTS_API::validate_api_key_value((string) $value);
                    if(!$check['success']){
                        self::$continue_verify = false;
                    }
                    self::$api_key = $value;
                    break;
                case 'voice_id':
                    $check = TTS_API::validate_voice_id_value($value, TTS_API::get_api_key(self::$api_key));
                    break;
            }
        }


        printf(
            '<input type="text" id="%s" name="%s[%s]" value="%s" placeholder="%s" class="regular-text">',
            esc_attr($args['id']),
            esc_attr(self::$option_name),
            esc_attr($args['id']),
            esc_attr($value),
            esc_attr($placeholder)
        );
        
        if (isset($args['description'])) {
            echo '<p class="description">' . $args['description'] . '</p>';
        }

        //render verify result
        if (isset($check)) {
            if (!$check['success']) {
                printf(
                    '<p class="description" style="color: #b00020;">%s</p>',
                    esc_html($check['error'])
                );
            } else {
                printf(
                    '<p class="description" style="color: #1b7a2a;">%s</p>',
                    esc_html($check['message'] ?? __('OK', 'kapital'))
                );
            }
        }
    }

    /**
     * Render credits row (non-option)
     * must be rendered after api, as it depends on api_key which is set first 
     */
    public static function credits_field_callback($args)
    {
        // get cached api key

        if (empty(self::$api_key)) {
            return;
        }

        $response = TTS_API::get_credits_value(self::$api_key);


        if (!is_array($response)) {
            echo '<p class="description" style="color:#b00020;">' . esc_html__('Neznáma chyba.', 'kapital') . '</p>';
            return;
        }

        if (empty($response['success'])) {
            printf(
                '<p class="description" style="color:#b00020;">%s</p>',
                esc_html($ressponse['error'] ?? __('Chyba pri načítaní kreditov.', 'kapital'))
            );
            return;
        }

        if (!is_array($response)) {
            echo '<p class="description" style="color:#b00020;">' . esc_html__('Neznáma chyba.', 'kapital') . '</p>';
            return;
        }

        if ($response['success']){
            $credits = $response['data'];
        } else {
            $credits = $response['error'];
        }
        echo '<p>' . number_format($credits, 0, ',', ' ') . '</p>';
        
    }
    

    /**
     * Sanitize options before saving
     */
    public static function sanitize_options($input)
    {
        $sanitized = array();

        foreach (self::$text_fields as $id => $field) {
            $sanitized[$id] = sanitize_text_field($input[$id]);
        }

        return $sanitized;
    }

    /**
     * Render the options page
     */
    public static function render_options_page()
    {
?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields(self::$option_group);
                do_settings_sections(self::$option_group);
                submit_button();
                ?>
            </form>
        </div>
<?php
    }



    /**
     * Get an option value
     */
    public static function get_option($key, $default = '')
    {
        $options = get_option(self::$option_name);
        return isset($options[$key]) ? $options[$key] : $default;
    }

    /**
     * Get all options
     */
    public static function get_all_options()
    {
        return get_option(self::$option_name, array());
    }

    /**
     * Update a single option
     */
    public static function update_option($key, $value)
    {
        $options = self::get_all_options();
        $options[$key] = $value;
        return update_option(self::$option_name, $options);
    }
}
