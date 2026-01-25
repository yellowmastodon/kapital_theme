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

?>
<div class="alignwide">
    <audio class="tts-audio plyr-audio" data-lang="<?= $lang ?>">
        <source src="<?= wp_get_attachment_url($audio_id) ?>" type="<?= get_post_mime_type($audio_id) ?>">
    </audio>
</div>