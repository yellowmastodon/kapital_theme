<?php

/**
 * Renders share dropdown
 */
defined('ABSPATH') || exit; 

$share_spermalink = get_the_permalink() . '?ref=share';
$encoded_share_permalink = urlencode(get_the_permalink() . '?ref=share');
?>

<div class="share-dropdown" >
    <button class="post-share-button main-share" aria-expanded="false" value=<?=$share_spermalink?>>
        <svg class="icon-square">
            <use xlink:href="#icon-share" ></use>
        </svg>Zdieľať</button>
    <ul class="share-dropdown-menu p-3 text-gray lh-sm" aria-labelledby="dropdownMenuButton1">
        <li><a target="_blank" href="<?= add_query_arg('u', $encoded_share_permalink, 'https://www.facebook.com/sharer.php') ?>"><svg class="icon-square me-2">
                    <use xlink:href="#icon-facebook"></use>
                </svg>Facebook</a></li>
        <li><a target="_blank" href="<?= add_query_arg('text', $encoded_share_permalink, 'https://bsky.app/intent/compose') ?>"><svg class="icon-square me-2">
                    <use xlink:href="#icon-bluesky"></use>
                </svg>Bluesky</a></li>
        <li><a target="_blank" href="mailto:<?= '?subject=' . urlencode(get_the_title()) . '&body=' . strip_tags(get_the_excerpt()) . '%0A' . $encoded_share_permalink; ?>"><svg class="icon-square me-2">
                    <use xlink:href="#icon-mail"></use>
                </svg>E-mail</a></li>
        <li><button data-copied-text="<?=__("Skopírované", "kapital")?>" value="<?=$share_spermalink?>" class="post-share-button link-share"><svg class="icon-square me-2">
                    <use xlink:href="#icon-link"></use>
                </svg><?= __("Kopírovať odkaz", "kapital") ?></button></li>
    </ul>
</div>