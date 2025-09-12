<?php
/**
 * Wraps code passed via $args['html'] in button that triggers lightbox gallery
 * @param $args['html'] hmtl to wrap
 */


if (isset($args['html'])):?>
<a role="button" data-bs-toggle="modal" data-bs-target="#kapital-gallery-modal" class="btn-gallery col-12" href="<?= wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full') ?>">
    <?=$args['html']?>
</a>
<?php endif;?>