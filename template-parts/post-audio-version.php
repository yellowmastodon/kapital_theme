<?php

/**
 * Renders audio version of post
 */
defined('ABSPATH') || exit; 

if (isset($args["audio_id"])){
    $audio_id = $args["audio_id"];
} else {
    return;
}

$lang = 'sk';

if (isset($args["lang"])){
    $lang = $args["lang"];
} 

$authors = [];
$author_str = '';

if (isset($args["autorstvo"])){
    $authors = $args["autorstvo"];
    foreach($authors as $author){
        if ($author_str !== '') $author_str .= ', ';
        $author_str .= $author->name;
    };
} 

if ($author_str === ''){
    $author_str = get_bloginfo( 'name' );
}

global $post;
$image_id = get_post_thumbnail_id( $post->ID );

// Define your custom sizes
$tts_sizes = [
    'tts_audio_thumb_64' => ['width' => 64, 'height' => 64, 'crop' => true],
    'tts_audio_thumb_128' => ['width' => 128, 'height' => 128, 'crop' => true],
    'tts_audio_thumb_256' => ['width' => 256, 'height' => 256, 'crop' => true],
    'tts_audio_thumb_512' => ['width' => 512, 'height' => 512, 'crop' => true],
];

// Check if subsizes already exist
$metadata = wp_get_attachment_metadata( $image_id );
$subsizes_exist = isset( $metadata['sizes'] ) && array_key_exists( 'tts_audio_thumb_64', $metadata['sizes'] );

if ( ! $subsizes_exist ) {
    if ( ! function_exists( 'wp_create_image_subsizes' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
    }
    
    // Save original registered sizes and temporarily replace with custom sizes
    global $_wp_additional_image_sizes;
    $original_sizes = $_wp_additional_image_sizes;
    $_wp_additional_image_sizes = $tts_sizes;
    
    $file = get_attached_file( $image_id );
    wp_create_image_subsizes( $file, $image_id );
    
    $_wp_additional_image_sizes = $original_sizes;
}

// Get the generated images
$image_arr = [];
foreach ( $tts_sizes as $key => $size ) {
    $img = wp_get_attachment_image_src( $image_id, $key );
    if ( $img ) {
        $image_arr[ $size['width'] ] = $img[0];
    }
}

$navigator_data = array(
    'title' => trim( strip_tags( $post->post_title ) ),
    'author' => $author_str,
    'thumb' => $image_arr,
    'site' => get_bloginfo( 'name' ),
    'thumb_mime' => get_post_mime_type( $image_id )
);


$audio_attachment = get_post($audio_id);
$tts_options = get_option('kptl_tts_settings');

if ($lang === 'en'){
    $description_short = $tts_options['player_text_en_short'] ?? '';
    $description = $tts_options['player_text_en'] ?? '';
    $more_text = 'More about audioversion';
    $less_text = 'Less about audioversion';
} else {
    $description_short = $tts_options['player_text_sk_short'] ?? '';
    $description = $tts_options['player_text_sk'] ?? '';
    $more_text = 'Viac o audioverzii';
    $less_text = 'Menej o audioverzii';
}

?>
<section class="alignwide plyr-audio-container">
    <h2 class="visually-hidden"><?= $lang === 'en' ? 'Audio version of the article' : 'Audio verzia článku' ?></h2>
    <audio class="tts-audio plyr-audio" data-lang="<?= $lang ?>" data-navigator-meta="<?= htmlspecialchars( json_encode( $navigator_data ), ENT_QUOTES, 'UTF-8' ) ?>">
        <source src="<?= wp_get_attachment_url($audio_id) ?>" type="<?= get_post_mime_type($audio_id) ?>">
    </audio>
    <?php

    $desc_id = 'tts-audio-description-' .  $audio_id; //for aria expanded

    if ($description_short !== '' || $description_short !== ''): 
        echo '<p id="' . $desc_id . '" class="tts-audio-description fs-small lh-sm text-gray ff-sans mt-1 d-block mx-auto px-1 px-sm-3 short">';
            if ($description_short === ''){
                echo $description;
            } else if ($description === ''){
                echo $description_short;
            } else {
                echo '<span class="tts-audio-description-short">' . $description_short . '</span>'
                . '<span class="tts-audio-description-long">' . $description . '</span>' //br forces "more" to newline
                . ' <a role="button" class="text-gray tts-audio-description-more" data-alt-text="' . $less_text . '" aria-controls="' . $desc_id . '" aria-expanded="false">' . $more_text . '</a>';
            }
        echo '</p>';

    endif; ?>
</section>
