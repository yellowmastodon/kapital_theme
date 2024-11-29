<?php
function ajax_load_ads(){
    if (!wp_verify_nonce($_POST['nonce'], 'ajax-nonce')) {
        die('');
    }
    /** ads are saved to the database with end date as "date"
     * first we query the ads that have date higher than today (today included)
     * then we filter ads that have start_date later than today
     */ 
    
    $ads = new WP_Query(array(
        'post_type' => 'inzercia',
        'posts_per_page' => -1,
        'date_query' => array(
            'after' => 'yesterday'
        )
    ));
    //remove ads that have not yet started
    $today = date('Y-m-d');
    foreach ($ads->posts as $key => $ad){
        $ad_start_date = get_field('ad_start_date', $ad->ID);
        if ($ad_start_date > $today){
            unset($ads->posts[$key]);
        }
    }
    $html = "";
    if (count($ads->posts) > 0){
        if ($_POST['single']){
            $random_ad_key = rand(0, count($ads->posts) - 1);
            $mobile_image = get_field('ad_mobile_image', $ads->posts[$random_ad_key]->ID);
            $destkop_image = get_field('ad_desktop_image', $ads->posts[$random_ad_key]->ID);
            $alt_text = get_field('ad_alt_text', $ads->posts[$random_ad_key]->ID);
            $url = get_field('ad_url', $ads->posts[$random_ad_key]->ID);
            $html .= '<a target="_blank" href="' . $url . '" data-ad-id="' . $ads->posts[$random_ad_key]->ID . '" class="my-6 d-print-none d-block inzercia alignwidest">';
            $html .= kapital_responsive_image($mobile_image, "95vw", false, "d-block d-sm-none w-100", "", $alt_text);
            $html .= kapital_responsive_image($destkop_image, "95vw, min-width(900px) 1260px, min-width(1680px) 1550px", false, "d-none d-sm-block w-100", "", $alt_text);
            $html .= '</a>';
        }
    }

    //var_dump($ads);
    echo $html;
    wp_die();
}
add_action('wp_ajax_adinserter', 'ajax_load_ads');
add_action('wp_ajax_nopriv_adinserter', 'ajax_load_ads');

function ajax_click_counter(){
    //only register non admin clicks
    if (!current_user_can('edit_posts')){
        $ad_id = $_POST["ad_id"];
        $current_count = get_post_meta($ad_id, '_ad_click_counter', true);
        $current_count++;
        update_post_meta($ad_id, '_ad_click_counter', $current_count);
    }
    wp_die();
}

add_action('wp_ajax_adclickcounter', 'ajax_click_counter');
add_action('wp_ajax_nopriv_adclickcounter', 'ajax_click_counter');

function ajax_get_views(){
    //only register non admin clicks
    $ids = explode(',', $_POST["ids"]);
    $stats = array();
    foreach($ids as $id){
        $stats[] = kapital_get_koko_stats((int)$id);
    }
    echo json_encode($stats);
    //echo $ids;
    wp_die();
}
add_action('wp_ajax_getviews', 'ajax_get_views');
add_action('wp_ajax_nopriv_getviews', 'ajax_get_views');


