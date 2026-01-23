<?php

class TTS_API
{
    private const DEFAULT_TIMEOUT = 600;
    private const ELEVENLABS_BASE_URL = 'https://api.elevenlabs.io/v1';

    /**
     * Get the stored API key from settings.
     */
    public static function get_api_key($api_key = null): string
    {
        if ($api_key === null || $api_key === '') {
            $api_key = TTS_Settings::get_option('api_key');
        } 
        self::validate_api_key_not_empty($api_key);
        return $api_key;
    }

    /**
     * Validate that API key is not empty.
     * Sends JSON error response and exits if empty.
     */
    private static function validate_api_key_not_empty(string $api_key): void
    {
        if (empty($api_key)) {
            wp_send_json([
                'success' => false,
                'error'   => __('API key prázdne.')
            ], 400);
        }
    }

    /**
     * Check if response is a WP_Error and return standardized error array.
     */
    private static function handle_wp_error($response): ?array
    {
        if (is_wp_error($response)) {
            return [
                'success' => false,
                'code'    => null,
                'data'    => null,
                'body'    => null,
                'error'   => 'HTTP Error: ' . $response->get_error_message(),
            ];
        }
        return null;
    }

    /**
     * Central HTTP request handler with unified error handling.
     *
     * @param string $method  HTTP method (GET, POST, PUT, DELETE, etc.)
     * @param string $url     Full URL to request
     * @param array  $options Configuration options:
     *   - 'api_key' (string|null): Override default API key
     *   - 'headers' (array): Additional headers
     *   - 'body' (array|string|null): Request body (auto-encoded to JSON if array)
     *   - 'timeout' (int): Request timeout in seconds
     *   - 'parse_json' (bool): Auto-parse JSON response (default: true)
     *   - 'request_args' (array): Additional wp_remote_* arguments
     *
     * @return array Standardized response:
     *   - 'success' (bool): Whether request succeeded
     *   - 'code' (int|null): HTTP status code
     *   - 'data' (mixed|null): Parsed response data
     *   - 'body' (string|null): Raw response body
     *   - 'error' (string|null): Error message if failed
     */
    private static function make_request(string $method, string $url, array $options = []): array
    {
        // Prepare headers
        $api_key = self::get_api_key($options['api_key'] ?? null);
        $headers = $options['headers'] ?? [];

        $headers['xi-api-key'] = $api_key;

        if (!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/json';
        }

        // Build request arguments
        $args = $options['request_args'] ?? [];
        $args['headers'] = $headers;
        $args['timeout'] = $options['timeout'] ?? self::DEFAULT_TIMEOUT;

        if (isset($options['body'])) {
            $args['body'] = is_array($options['body'])
                ? wp_json_encode($options['body'])
                : $options['body'];
        }

        // Execute request
        $method = strtoupper($method);
        $response = match ($method) {
            'GET' => wp_remote_get($url, $args),
            'POST' => wp_remote_post($url, $args),
            default => wp_remote_request($url, array_merge($args, ['method' => $method]))
        };

        // Handle WP_Error
        if ($error = self::handle_wp_error($response)) {
            return $error;
        }

        // Parse response
        $http_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $parse_json = $options['parse_json'] ?? true;

        $data = null;

        if ($parse_json && !empty($body)) {
            $decoded = json_decode($body, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data = $decoded;
            }
        } elseif (!$parse_json) {
            $data = $body;
        }

        // Check for HTTP-level API key errors (401 Unauthorized)
        if ($http_code === 401) {
            return [
                'success' => false,
                'code'    => $http_code,
                'data'    => null,
                'body'    => $body,
                'error'   => __('Nesprávny API kľúč.', 'kapital'),
            ];
        }

        return [
            'success' => true,
            'code'    => $http_code,
            'data'    => $data,
            'error'   => null,
        ];
    }

    /**
     * Generate speech audio from text using ElevenLabs API.
     *
     * @param string $text Text to convert to speech
     * @return binary Audio data on success, WP_Error on failure
     */
    public static function generate_speech(string $text)
    {
        $voice_id = TTS_Settings::get_option('voice_id');
        $url = self::ELEVENLABS_BASE_URL . '/text-to-speech/' . $voice_id;

        $result = self::make_request('POST', $url, [
            'body' => [
                'output_format' => 'mp3_44100_128',
                'text'     => $text,
                'model_id' => 'eleven_turbo_v2_5',
            ],
            'parse_json' => false, // Expecting binary audio data
        ]);

        if (!$result['success']) {
            return new WP_Error('tts_request_failed', $result['error'] ?? 'Unknown error');
        }

        return $result['data'];
    }

    /**
     * Get user subscription and credit information. (REST wrapper)
     *
     * @param WP_REST_Request $request REST request object
     * @return array Response with subscription data or error
     */
    public static function get_credits(WP_REST_Request $request): array
    {
        return self::get_credits_value($request->get_param('api_key'));
       
    }

    public static function get_credits_value($api_key = null){

        //get fallback value
        $api_key = self::get_api_key($api_key);
        
        $url = self::ELEVENLABS_BASE_URL . '/user/subscription';

        $result = self::make_request('GET', $url, [
            'api_key' => $api_key,
        ]);

        if (!$result['success']) {
            return [
                'success' => false,
                'error'   => $result['error'],
            ];
        }

        $credits_left = $result['data']['character_limit'] - $result['data']['character_count'];

        return [
            'success' => true,
            'data'    => $credits_left,
        ];
    }

    /**
     * Validate an API key (can be used outside REST handlers).
     *
     * @param string $api_key
     * @return array { success: bool, message?: string, error?: string, data?: mixed }
     */
    public static function validate_api_key_value(string $api_key): array
    {
        if (empty($api_key)) {
            return [
                'success' => false,
                'error'   => __('API key is empty', 'kapital'),
            ];
        }

        $url = self::ELEVENLABS_BASE_URL . '/models';
        $result = self::make_request('GET', $url, [
            'api_key'   => $api_key,
            'parse_json' => true,
        ]);

        if (!$result['success']) {
            return [
                'success' => false,
                'error'   => $result['error'] ?? __('Unknown request error', 'kapital'),
            ];
        }

        if ($result['code'] === 200) {
            return [
                'success' => true,
                'message' => __('API kľúč je platný.', 'kapital'),
                'data'    => $result['data'] ?? null,
            ];
        }

        return [
            'success' => false,
            'error'   => 'HTTP ' . ($result['code'] ?? '0') . ': ' . ($result['body'] ?? ''),
        ];
    }

    /**
     * REST wrapper — reuses validate_api_key_value
     */
    public static function validate_api_key(WP_REST_Request $request): array
    {
        $api_key = self::get_api_key($request->get_param('api_key'));
        return self::validate_api_key_value((string) $api_key);
    }

    /**
     * Validate a voice ID by checking if it exists in ElevenLabs.
     *
     * @param WP_REST_Request $request REST request object
     * @return array Validation result
     */
    public static function validate_voice_id_value(string $voice_id, ?string $api_key = null): array
    {
        if (empty($voice_id)) {
            return [
                'success' => false,
                'error'   => __('Voice id je prázdne.', 'kapital'),
            ];
        }

        // resolve api key (falls back to stored key) and validate
        $api_key = self::get_api_key($api_key);
        $url = self::ELEVENLABS_BASE_URL . '/voices/' . rawurlencode($voice_id);

        $result = self::make_request('GET', $url, [
            'api_key'   => $api_key,
            'parse_json' => true,
        ]);

        if (!$result['success']) {
            return [
                'success' => false,
                'error'   => $result['error'] ?? __('Unknown request error.', 'kapital'),
            ];
        }

        if ($result['code'] === 200) {
            $voice_name = $result['data']['name'] ?? 'Unknown';
            return [
                'success' => true,
                'message' => sprintf(__('Úspech, nájdený hlas: "%s"'), $voice_name),
                'data'    => $result['data'],
            ];
        }

        $error_message = $result['data']['detail']['message'] ?? $result['body'] ?? __('Unknown error', 'kapital');
        return [
            'success' => false,
            'error'   => $error_message,
        ];
    }

    public static function validate_voice_id(WP_REST_Request $request): array
    {
        $voice_id = (string) $request->get_param('voice_id');
        $api_key  = self::get_api_key($request->get_param('api_key'));

        return self::validate_voice_id_value($voice_id, $api_key);
    }
}
