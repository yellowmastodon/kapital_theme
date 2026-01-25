<?php
class TTS_Loader
{

    public static function init()
    {
        // Load dependencies
        self::load_dependencies();

        TTS_Settings::init();
        TTS_Meta::init();
        TTS_Rest::init();

        self::load_frontend_styles_and_scripts();
    }

    private static function load_dependencies()
    {
        $dir = __DIR__ . '/';
        require_once $dir . 'class-tts-settings.php';
        require_once $dir . 'class-tts-meta.php';
        require_once $dir . 'class-tts-api.php';
        require_once $dir . 'class-tts-rest.php';
    }

    private static function load_frontend_styles_and_scripts()
    {
        //not directly, but with add_action, as global $post would not be loaded yet
        add_action('wp_enqueue_scripts', function () {

            if (is_admin()) {
                return;
            }

            global $post;

            if (!$post) {
                $post = get_queried_object();
            }


            if ($post->post_type !== 'post') {
                return;
            }

            $audio_id = (int) get_post_meta($post->ID, TTS_Meta::META_AUDIO_ID, true);

            //var_dump($audio_id);;

            if (! $audio_id) {
                return;
            }

            wp_enqueue_style(
                'plyr-styles',
                get_stylesheet_directory_uri() . '/css/plyr-custom.min.css?mod=' . filemtime(get_stylesheet_directory() . '/css/plyr-custom.min.css'),
                [],
                null
            );

            //register script
            wp_register_script(
                'plyr',
                get_stylesheet_directory_uri() . '/js/plyr.min.js?mod=' . filemtime(get_stylesheet_directory() . '/js/plyr.min.js'),
                [],
                null,
                true
            );

            wp_enqueue_script(
                'plyr-init',
                get_stylesheet_directory_uri() . '/js/plyr-init.min.js?mod=' . filemtime(get_stylesheet_directory() . '/js/plyr-init.min.js'),
                ['plyr'],
                null,
                true
            );

        });
    }

    public static function log($message, $context = [])
    {
        if (!empty($context)) {
            $message .= ' | ' . wp_json_encode($context);
        }
        error_log('[TTS] ' . $message);
    }
}
