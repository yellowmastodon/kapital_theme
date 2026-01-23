<?php
class TTS_Loader {
    
    public static function init() {
        // Load dependencies
        self::load_dependencies();
        
        // Initialize settings always (needed for REST and front-end)
        TTS_Settings::init();

        // Initialize based on context
   /*      if (is_admin()) {
            self::init_admin();
        }
         */
        // Always load (for REST API, works on front-end too)
        self::init_global();
    }
    
    private static function load_dependencies() {
        $dir = __DIR__ . '/';
        require_once $dir . 'class-tts-settings.php';
        require_once $dir . 'class-tts-meta.php';
        //require_once $dir . 'class-tts-ajax.php';
        require_once $dir . 'class-tts-api.php';
        require_once $dir . 'class-tts-rest.php';
    }
    
/*     private static function init_admin() {
        TTS_Ajax::init();
    } */
    
    private static function init_global() {
        TTS_Meta::init();
        TTS_Rest::init();
    }

    public static function log($message, $context = []) {
        if (!empty($context)) {
            $message .= ' | ' . wp_json_encode($context);
        }
        error_log('[TTS] ' . $message);
    }

}