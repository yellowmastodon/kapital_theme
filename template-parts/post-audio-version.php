<?php

/**
 * Renders share dropdown
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

do_action('qm/debug', $tts_options);

?>
<section class="alignwide plyr-audio-container">
    <h2 class="visually-hidden"><?= $lang === 'en' ? 'Audio version of the article' : 'Audio verzia článku' ?></h2>
    <audio class="tts-audio plyr-audio" data-lang="<?= $lang ?>">
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
