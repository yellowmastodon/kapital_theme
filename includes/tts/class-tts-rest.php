<?php
class TTS_Rest
{

    public static function init()
    {
        add_action('rest_api_init', array(__CLASS__, 'register_routes'));
    }

    public static function register_routes()
    {
        register_rest_route('tts/v1', '/start', array(
            'methods' => 'POST',
            'callback' => array(__CLASS__, 'start'),
            'permission_callback' => array(__CLASS__, 'check_permission')
        ));

        /** no permission callback, checks token inside the method */
        register_rest_route('tts/v1', '/process', array(
            'methods' => 'POST',
            'callback' => array(__CLASS__, 'process_tts'),
        ));

        /** called from gutenberg */
        register_rest_route('tts/v1', '/refresh-meta', [
            'methods' => 'POST',
            'callback' => array(__CLASS__, 'refresh_meta'),
            'permission_callback' => array(__CLASS__, 'check_permission')
        ]);

        register_rest_route('tts/v1', '/validate-api-key', array(
            'methods' => 'POST',
            'callback' => array('TTS_API', 'validate_api_key'),
            'permission_callback' => array(__CLASS__, 'check_permission')
        ));

        register_rest_route('tts/v1', '/validate-voice-id', array(
            'methods' => 'POST',
            'callback' => array('TTS_API', 'validate_voice_id'),
            'permission_callback' => array(__CLASS__, 'check_permission')
        ));

        register_rest_route('tts/v1', '/credits', array(
            'methods' => 'GET',
            'callback' => array('TTS_API', 'get_credits'),
            'permission_callback' => array(__CLASS__, 'check_permission')
        ));
    }

    public static function start(WP_REST_Request $request)
    {
        $post_id = absint($request->get_param('post_id'));
        $post = get_post($post_id);

        if (!$post) {
            wp_send_json_error('Invalid post ID:' . $post_id);
        }

        /**
         * token used for verification, so that process can only be spawned from this call
         * process includes no other permission checks, as it is called directly from this endpoint
         * 20 chars should be more than enough 
         */
        $token = wp_generate_password(20, false);

        set_transient("kptl_tts_process_token_$token", true, 10 * MINUTE_IN_SECONDS);

        // Get post content and normalize
        $text = self::normalize_post_content($post);

        // Trigger REST API call in background
        $rest_url = rest_url('tts/v1/process');
 
        wp_remote_post($rest_url, array(
            'blocking' => false, // Non-blocking, runs in background
            'body' => json_encode(array(
                'post_id' => $post_id,
                'text' => $text,
                'token' => $token
            )),
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization'=> 'Basic ' . base64_encode('Vsetcizomrieme:Vsetcizomrieme') // htpasswd creds
            )
        )); 

        wp_send_json_success(__('Process started.'));

        //only for testing purposes
        //wp_send_json_success($text);
    }

    private static function normalize_post_content($post, $options = [])
    {

        $defaults = [
            'paragraph_pause' => .5, //in seconds
            'heading_pause' => .7,
            'list_item_pause' => .3,
            'use_ssml' => true,
            'skip_classes' => ['darujme-form-wrapper', 'wp-block-buttons', 'wp-block-kapital-ad', 'inzercia'],

            'include_block_elements' => [
                // Block elements only
                'p',
                'blockquote',
                'pre',
                'h1',
                'h2',
                'h3',
                'h4',
                'h5',
                'h6',
                'ul',
                'ol',
                'li',
                'dl',
                'dt',
                'dd',
                'details',
                'summary',
                'div',
                'article',
                'section',
                'main', // Structure (process children)
                //'table', 'thead','tbody','tfoot','tr','td', 'th', // Tables, might reconsider
                'body',
                'html', // Root elements
            ],

            'include_inline_elements' => [
                'a',
                'abbr',
                'b',
                'strong',
                'i',
                'em',
                'u',
                'small',
                'sub',
                'sup',
                'mark',
                'span',
                'code',
                'kbd',
                'var',
                'samp',
                'cite',
                'time',
                'q', //inline tags
            ],
            'manual_strings' => [
                'sk' => [
                    'author' => 'Autorstvo textu',
                    'footnote' => 'Poznámka pod čiarou',
                ],
                'cs' => [
                    'author' => 'Autorství textu',
                    'footnote' => 'Poznámka pod čarou',
                ],
                'en' => [
                    'author' => 'Author',
                    'footnote' => 'Footnote'
                ]
            ],
            'lang' => 'sk',
            'footnotes' => [] //footnotes from meta, passed to extract_text_with_pauses
        ];

        $options = array_merge($defaults, $options);

        if (!$post) {
            return '';
        }

        setup_postdata($post);

        $secondary_title = get_post_meta($post->ID, '_secondary_title', true);

        //ensure sentence end and add whitespace
        if ($secondary_title && $secondary_title !== '') {
            $secondary_title = ' ' . self::ensure_sentence_end($secondary_title);
        } else {
            $secondary_title = '';
        }

        //setup author string
        $terms = get_and_reorganize_terms($post->ID, ['autorstvo', 'jazyk']);

        //we let automatic detection of elevenlabs decide the language of the text, this is just for manually inserted strings
        $options['lang'] = 'sk';

        if (isset($terms['jazyk']) && count($terms['jazyk'])) {

            $lang_strings_arr = array_map(function ($term,) {
                return strtolower($term->slug);
            }, $terms['jazyk']);

            if (in_array('english', $lang_strings_arr) || in_array('en', $lang_strings_arr)) {

                $options['lang'] = 'en';

            } else if (in_array('czech', $lang_strings_arr) || in_array('cs', $lang_strings_arr) || in_array('cesky', $lang_strings_arr) || in_array('cz', $lang_strings_arr)) {
               
                $options['lang'] = 'cs';

            }
        }

        $authors_string = '';

        if (count($terms)) {
            foreach ($terms['autorstvo'] as $key => $author) {
                if ($key !== 0) $authors_string .= ", ";
                $authors_string .= $author->name;
            }
        }

        if ($authors_string !== '') {
            $authors_string = " <break time=\"{$options['heading_pause']}s\"/>{$options['manual_strings'][$options['lang']]['author']}: " . self::ensure_sentence_end($authors_string);
        }

        //setup footnotes
        $footnotes_meta = get_post_meta($post->ID, 'footnotes', true);
        if ($footnotes_meta) {
            $footnotes_meta = json_decode($footnotes_meta);
            if (count($footnotes_meta)) {
                foreach ($footnotes_meta as $footnote) {
                    $id = $footnote->id;

                    $text = $footnote->content;
                    $text = trim(strip_tags(html_entity_decode($footnote->content)));
                    $text = preg_replace('/\s+/', ' ', $text); // normalize spaces

                    $options['footnotes'][$id] = $text;
                }
            }
        }

        $content = apply_filters('the_content', $post->post_content);

        wp_reset_postdata();

        $content = strip_shortcodes($content);
        $content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $content);
        $content = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $content);
        $content = preg_replace('/<noscript\b[^>]*>(.*?)<\/noscript>/is', '', $content);
        $content = preg_replace('/<!--(.|\s)*?-->/', '', $content);
        $content = preg_replace('/<iframe[^>]*>.*?<\/iframe>/is', '[Embedded Media] ', $content);

        $dom = new DOMDocument();
        $previous_value = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
        libxml_clear_errors();
        libxml_use_internal_errors($previous_value);

        $text_parts = [];
        self::extract_text_with_pauses($dom->documentElement, $text_parts, $options);

        $result = implode('', $text_parts);
        $result = html_entity_decode($result, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $result = preg_replace('/\s+/', ' ', $result);
        //$result = preg_replace('/(\.\s*){3,}/', '.. ', $result);
        $result = trim($result);
        //prepend authors and title
        $result = self::ensure_sentence_end($post->post_title) . $secondary_title . $authors_string . " <break time=\"{$options['heading_pause']}s\"/>" . $result;

        return $result;
    }

    private static function extract_text_with_pauses($node, &$text_parts, $options)
    {
        $pause_map = [
            'p' => $options['paragraph_pause'],
            'blockquote' => $options['paragraph_pause'],
            'li' => $options['list_item_pause'],
            'h1' => $options['heading_pause'],
            'h2' => $options['heading_pause'],
            'h3' => $options['heading_pause'],
            'h4' => $options['heading_pause'],
            'h5' => $options['heading_pause'],
            'h6' => $options['heading_pause'],
        ];

        $allowed_elements = array_merge($options['include_block_elements'], $options['include_inline_elements']);

        // Handle text nodes (children of element nodes)
        if ($node->nodeType === XML_TEXT_NODE) {
            $text = $node->textContent;
            if (!empty($text)) {

                $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $text = preg_replace('/\s+/', ' ', $text);
                $text_parts[] = $text;
            }
            return;
        }

        if ($node->nodeType !== XML_ELEMENT_NODE) {
            return;
        }

        $tag_name = strtolower($node->nodeName);

        //Handle element nodes
        if (!in_array($tag_name, $allowed_elements)) {
            return;
        }

        // Skip by class name
        if ($node->hasAttribute('class')) {
            $classes = explode(' ', $node->getAttribute('class'));

            foreach ($options['skip_classes'] as $skip_class) {
                if (in_array($skip_class, $classes)) {
                    return;
                }
            }
        }

        //handle footnotes
        if ($tag_name === 'a') {
            if ($node->hasAttribute('href')) {
                $href = $node->getAttribute('href');
                if ($href && $href !== '' && str_starts_with($href, '#')) {
                    $href_id = ltrim(trim($href), '#');
                    if (array_key_exists($href_id, $options['footnotes'])) {
                        $text_parts[] = ' ' . "{$options['manual_strings'][$options['lang']]['footnote']}: " . self::ensure_sentence_end($options['footnotes'][$href_id]) . ' ';
                        return;
                    }
                }
            }
        }

        $start_index = count($text_parts);

        // Process children
        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $child) {
                self::extract_text_with_pauses($child, $text_parts, $options);
            }
        }

        //add whitespace after block elements


        // Add appropriate pause after selected block elements
        if (isset($pause_map[$tag_name]) && count($text_parts) > $start_index) {
            $pause_ms = $pause_map[$tag_name];

            if ($options['use_ssml']) {
                $text_parts[] = "<break time=\"{$pause_ms}s\"/>";
            } else {
                $text_parts[] = str_repeat('.', max(1, round($pause_ms / 200))) . ' ';
            }
        }
    }

    public static function ensure_sentence_end($text)
    {
        $text = trim($text); // remove trailing spaces

        // Check if ends with ., !, ?, or …
        if (!preg_match('/(\.\.\.|…|[.!?])$/u', $text)) {
            $text .= '.'; // append period if missing
        }


        return $text;
    }

    public static function check_permission()
    {
        // Only allow internal requests
        return current_user_can('edit_posts');
    }

    public static function process_tts(WP_REST_Request $request)
    {
        $token = $request->get_param('token');

        if (!$token || !get_transient("kptl_tts_process_token_$token")) {
            TTS_Loader::log('Invalid or missing token', ['token' => $token]);
            return new WP_Error(
                'forbidden',
                'Invalid or missing token.',
                array('status' => 403)
            );
        }

        delete_transient("kptl_tts_process_token_$token");
        TTS_Loader::log('Token validated and transient deleted');

        $post_id = (int) $request->get_param('post_id');
        $text = $request->get_param('text');

        TTS_Loader::log('Starting TTS process', ['post_id' => $post_id, 'text_length' => strlen($text)]);

        // Update status to processing, bump state rev so that it cannot be overwritten
        TTS_Meta::update_status_backend($post_id, TTS_Meta::STATUS_PROCESSING);
        TTS_Loader::log('Updated post status to PROCESSING', ['post_id' => $post_id]);


        try {
            // Call ElevenLabs API
            $audio_data = TTS_API::generate_speech($text);

            if (is_wp_error($audio_data)) {
                TTS_Meta::update_status($post_id, TTS_Meta::STATUS_API_ERROR);

                TTS_Loader::log(
                    'ElevenLabs API returned WP_Error',
                    [
                        'post_id' => $post_id,
                        'error_code' => $audio_data->get_error_code(),
                        'error_message' => $audio_data->get_error_message(),
                    ]
                );

                return new WP_Error('api_error', $audio_data->get_error_message());
            }

            TTS_Loader::log('ElevenLabs API call successful', ['post_id' => $post_id]);

            // Upload to media library
            $audio_id = self::upload_audio($audio_data, $post_id);

            if (is_wp_error($audio_id)) {
                TTS_Meta::update_status($post_id, TTS_Meta::STATUS_API_ERROR);

                TTS_Loader::log(
                    'Audio upload failed',
                    [
                        'post_id' => $post_id,
                        'error_code' => $audio_id->get_error_code(),
                        'error_message' => $audio_id->get_error_message(),
                    ]
                );

                return $audio_id;
            }

            TTS_Loader::log('Audio upload successful', ['post_id' => $post_id, 'audio_id' => $audio_id]);

            // Update meta
            TTS_Meta::update_audio_id($post_id, $audio_id);
            TTS_Meta::update_status($post_id, TTS_Meta::STATUS_COMPLETED);
            TTS_Loader::log('Updated post meta with audio ID and status COMPLETED', ['post_id' => $post_id, 'audio_id' => $audio_id]);

            return array('success' => true, 'audio_id' => $audio_id);
            
        } catch (Exception $e) {
            TTS_Meta::update_status($post_id, TTS_Meta::STATUS_TIMEOUT);

            TTS_Loader::log(
                'Exception caught during TTS processing',
                [
                    'post_id' => $post_id,
                    'exception_message' => $e->getMessage(),
                    'exception_file' => $e->getFile(),
                    'exception_line' => $e->getLine(),
                ]
            );

            return new WP_Error('timeout', $e->getMessage());
        }
    }

    public static function refresh_meta(WP_REST_Request $request){

        $post_id = $request->get_param('post_id');

        wp_send_json_success([
            TTS_Meta::META_STATUS => TTS_Meta::get_status($post_id),
            TTS_Meta::META_AUDIO_ID => TTS_Meta::get_audio_id($post_id),
            TTS_Meta::META_STATE_REV => TTS_Meta::get_state_rev($post_id),
        ]);
    }

    private static function upload_audio($audio_data, $post_id)
    {
        if (!function_exists('wp_handle_upload')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }
        if (!function_exists('wp_generate_attachment_metadata')) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
        }
        if (!function_exists('wp_read_audio_metadata')) {
            require_once ABSPATH . 'wp-admin/includes/media.php';
        }

        $post_title = get_the_title($post_id);

        $slug = get_post_field('post_name', $post_id);

        //no slug yet? concepts without title? just to be sure
        if (empty($slug)) {
            $slug = $post_id;
        }

        $filename = 'tts-' . $slug . '-' . time() . '.mp3';
        $upload = wp_upload_bits($filename, null, $audio_data);

        if ($upload['error']) {
            TTS_Loader::log($upload['error']);
        }

        $attachment = array(
            'post_mime_type' => 'audio/mpeg',
            'post_title' => 'TTS Audio pre článok "' .  $post_title . '"',
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment($attachment, $upload['file'], $post_id);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
        wp_update_attachment_metadata($attach_id, $attach_data);

        return $attach_id;
    }
}
