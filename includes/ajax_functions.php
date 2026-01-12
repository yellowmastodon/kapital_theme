<?php
function ajax_load_ads() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'ajax-nonce')) {
        die('');
    }

    $data = array();
    $data["ads"] = array();
    $data["donation_form"] = "";

    // Check if 'ad' parameter is provided and is a valid JSON string
    if (isset($_POST["ad"]) && json_decode($_POST["ad"])) {
        // Query ads
        $ads = new WP_Query(array(
            'post_type' => 'inzercia',
            'posts_per_page' => -1,
            'date_query' => array(
                'after' => current_time('Y-m-d H:i:s'),
                'inclusive' => true,
                'column'    => 'post_date',
            )
        ));

        // Filter ads based on start date (ads that haven't started yet)
        $today = date('Y-m-d');
        foreach ($ads->posts as $key => $ad) {
            $ad_start_date = get_field('ad_start_date', $ad->ID);
            if ($ad_start_date > $today) {
                unset($ads->posts[$key]);
                $ads->posts = array_values($ads->posts);
            }
        }

        // Generate ad HTML based on whether "onead" is passed
        if (isset($_POST["onead"]) && json_decode($_POST["onead"])) {
            // Single random ad
            if (count($ads->posts) > 0) {
                $random_ad_key = rand(0, count($ads->posts) - 1);
                $ad = $ads->posts[$random_ad_key];
                $mobile_image = get_field('ad_mobile_image', $ad->ID);
                $desktop_image = get_field('ad_desktop_image', $ad->ID);
                $alt_text = get_field('ad_alt_text', $ad->ID);
                $url = get_field('ad_url', $ad->ID);

                $html = '<a target="_blank" href="' . esc_url($url) . '" data-ad-id="' . esc_attr($ad->ID) . '" class="my-6 d-print-none d-block inzercia alignwidest">';
                $html .= kapital_responsive_image($mobile_image, "95vw", false, "d-block d-sm-none w-100", "", esc_attr($alt_text));
                $html .= kapital_responsive_image($desktop_image, "(min-width: 2099px) 1800px, (min-width: 1649px) 1550px, (min-width: 1399px) 1260px, 95vw+", false, "d-none d-sm-block w-100", "", esc_attr($alt_text));
                $html .= '</a>';

                $data["ads"][] = $html;

            }
        } else {
            // All ads
            foreach ($ads->posts as $ad) {
                $mobile_image = get_field('ad_mobile_image', $ad->ID);
                $desktop_image = get_field('ad_desktop_image', $ad->ID);
                $alt_text = get_field('ad_alt_text', $ad->ID);
                $url = get_field('ad_url', $ad->ID);

                $ad_html = '<a target="_blank" href="' . esc_url($url) . '" data-ad-id="' . esc_attr($ad->ID) . '" class="my-6 d-print-none d-block inzercia alignwidest">';
                $ad_html .= kapital_responsive_image($mobile_image, "95vw", false, "d-block d-sm-none w-100", "", esc_attr($alt_text));
                $ad_html .= kapital_responsive_image($desktop_image, "(min-width: 2099px) 1800px, (min-width: 1649px) 1550px, (min-width: 1399px) 1260px, 95vw+", false, "d-none d-sm-block w-100", "", esc_attr($alt_text));
                $ad_html .= '</a>';

                $data["ads"][] = $ad_html;
                shuffle($data["ads"]);
            }
        }
    }

    // Check if 'donation' parameter is set
    if (isset($_POST["donation"]) && json_decode($_POST["donation"])) {
        ob_start();
        get_template_part('template-parts/donation-form', null, array("collapsed" => true));
        $data["donation_form"] = ob_get_clean();
    }

    // Output the response as JSON
    echo json_encode($data);

    wp_die();
}

add_action('wp_ajax_adinserter', 'ajax_load_ads');
add_action('wp_ajax_nopriv_adinserter', 'ajax_load_ads');

function ajax_click_counter()
{
    //only register non admin clicks
    if (!current_user_can('edit_posts')) {
        $ad_id = $_POST["ad_id"];
        $current_count = get_post_meta($ad_id, '_ad_click_counter', true);
        $current_count++;
        update_post_meta($ad_id, '_ad_click_counter', $current_count);
    }
    wp_die();
}

add_action('wp_ajax_adclickcounter', 'ajax_click_counter');
add_action('wp_ajax_nopriv_adclickcounter', 'ajax_click_counter');

function ajax_get_views()
{
    if (!wp_verify_nonce($_POST['nonce'], 'ajax-nonce')) {
        wp_send_json_error('Nonce verification failed');
    }    
    
    if ( empty($_POST['ids']) ) {
        wp_send_json_error('No IDs provided');
    }

    $ids = array_map('intval', array_map('trim', explode(',', $_POST['ids'])));
    $stats = array();

    foreach ($ids as $id) {
        if ($id > 0) {
            $stats[] = kapital_get_koko_stats($id);
        }
    }

    wp_send_json_success($stats);
}

add_action('wp_ajax_getviews', 'ajax_get_views');
add_action('wp_ajax_nopriv_getviews', 'ajax_get_views');
