<?php

class TTS_Meta
{

    const META_STATUS = '_kptl_tts_status';
    const META_AUDIO_ID = '_kptl_tts_audio_id';

    //Race condition guard, so that audio id and status
    //cannot be overwritten when processing
    const META_STATE_REV  = '_kptl_tts_state_rev';

    // Status constants
    const STATUS_NOT_STARTED = 0;
    const STATUS_TIMEOUT = 1;
    const STATUS_API_ERROR = 2;
    const STATUS_PROCESSING = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_MANUAL_UPLOAD = 5;

    private static $incoming_state_rev = null;
    private static $is_backend_update = false;

    public static function init()
    {

        add_action('init', array(__CLASS__, 'register_meta'));


        // Capture state_rev from REST request BEFORE meta is saved
        add_filter('rest_pre_insert_post', [__CLASS__, 'capture_rest_state_rev'], 10, 2);

        // Guard individual meta updates
        add_filter('update_post_metadata', [__CLASS__, 'guard_meta_update'], 10, 5);

        // Clear context after save
        add_action('rest_after_insert_post', [__CLASS__, 'clear_state_rev_context']);
    }

    public static function register_meta()
    {
        register_post_meta('post', self::META_STATUS, array(
            'type' => 'integer',
            'single' => true,
            'default' => self::STATUS_NOT_STARTED,
            'show_in_rest' => true,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            }
        ));

        register_post_meta('post', self::META_AUDIO_ID, array(
            'type' => 'integer',
            'single' => true,
            'show_in_rest' => true,
            'default' => 0, //return zero when no attachment saved
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            }
        ));

        //Revision number - prevents from Gutenberg saving stale meta
        register_post_meta('post', self::META_STATE_REV, [
            'type'         => 'integer',
            'single'       => true,
            'default'      => 0,
            'show_in_rest' => true,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        ]);
    }

    public static function get_status($post_id)
    {
        return (int) get_post_meta($post_id, self::META_STATUS, true);
    }

    public static function update_status($post_id, $status)
    {
        return update_post_meta($post_id, self::META_STATUS, $status);
    }

    public static function get_state_rev($post_id)
    {
        return (int) get_post_meta($post_id, self::META_STATE_REV, true);
    }

    public static function bump_state_rev($post_id)
    {
        $rev = self::get_state_rev($post_id);
        return update_post_meta($post_id, self::META_STATE_REV, $rev + 1);
    }

    /**
     * Update status and bump revision - BACKEND AUTHORITATIVE UPDATE
     */
    public static function update_status_backend($post_id, $status)
    {
        self::$is_backend_update = true;

        self::update_status($post_id, $status);
        self::bump_state_rev($post_id);

        self::$is_backend_update = false;
    }

    public static function get_audio_id($post_id)
    {
        return (int) get_post_meta($post_id, self::META_AUDIO_ID, true);
    }

    public static function update_audio_id($post_id, $audio_id)
    {
        return update_post_meta($post_id, self::META_AUDIO_ID, $audio_id);
    }

    /**
     * Guard against stale metadata updates
     */
    public static function guard_meta_update($check, $object_id, $meta_key, $meta_value, $prev_value)
    {
        // NEVER block backend updates
        if (self::$is_backend_update) {
            return $check; // allow update
        }

        $guarded_keys = [
            self::META_STATUS,
            self::META_AUDIO_ID,
        ];

        if (!in_array($meta_key, $guarded_keys)) {
            return $check; // allow other meta
        }

        // If we don't have context, allow update (not from REST)
        if (self::$incoming_state_rev === null) {
            return $check;
        }

        $current_rev = self::get_state_rev($object_id);

        // Block stale updates
        if (self::$incoming_state_rev < $current_rev) {
            TTS_Loader::log("BLOCKED stale meta update", [
                'meta_key' => $meta_key,
                'incoming_rev' => self::$incoming_state_rev,
                'current_rev' => $current_rev,
            ]);

            return true; // short-circuit (block update)
        }

        return $check; // allow update
    }

    public static function capture_rest_state_rev($prepared_post, WP_REST_Request $request) {
        $json_params = $request->get_json_params();
        
        // No meta in request = nothing to guard
        if (!isset($json_params['meta'])) {
            return $prepared_post;
        }
        
        $meta = $json_params['meta'];
        
        if (isset($meta[self::META_STATE_REV])) {
            self::$incoming_state_rev = (int) $meta[self::META_STATE_REV];
            TTS_Loader::log('Captured state_rev for guard', ['rev' => self::$incoming_state_rev]);
        }
        
        return $prepared_post;
    }

    public static function clear_state_rev_context($post) {
        self::$incoming_state_rev = null;
    }

    public static function get_status_label($status)
    {
        $labels = array(
            self::STATUS_NOT_STARTED => __("Nespustené", 'kapital'),
            self::STATUS_TIMEOUT => __("Chyba: Timeout", 'kapital'),
            self::STATUS_API_ERROR => __("Chyba: ElevenLabs API", 'kapital'),
            self::STATUS_PROCESSING => __("Prebieha konverzia", 'kapital'),
            self::STATUS_COMPLETED => __("Úspešné", 'kapital'),
            self::STATUS_MANUAL_UPLOAD => __("Manuálne nahrané audio", 'kapital'),
        );

        return isset($labels[$status]) ? $labels[$status] : 'Unknown';
    }
}
