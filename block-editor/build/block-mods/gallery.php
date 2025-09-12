<?php
/**
 * Gallery compatibility with bootstrap and masonry wrapper
 * not ideal solution. Creating custom block would be cleaner
 */
add_filter('render_block', 'kapital_render_gallery', 10, 2);

function kapital_render_gallery($block_content, $block)
{
    if ($block['blockName'] !== 'core/gallery') {
        return $block_content;
    }

    // Ensure the lightbox placeholder is only added once
    static $modal_placeholder_added = false;
    if (!$modal_placeholder_added) {
        add_action('kapital-before-footer', function () {
            get_template_part('template-parts/gallery-lightbox-placeholder');
        });
        $modal_placeholder_added = true;
    }

    $attributes = $block['attrs'];
    $align = $attributes['align'] ?? 'full';
    if ($align === '') $align = 'normal';

    // Determine spacing (gap-x and gap-y) from blockGap style
    $gx = $gy = '3'; // Default gap values
    if (!empty($attributes['style']['spacing']['blockGap'])) {
        $gap = $attributes['style']['spacing']['blockGap'];
        if (is_string($gap) && str_contains($gap, 'var:preset|spacing|')) {
            $gx = $gy = str_replace('var:preset|spacing|', '', $gap);
        } elseif (is_array($gap)) {
            if (!empty($gap['left'])) {
                $gx = str_replace('var:preset|spacing|', '', $gap['left']);
            }
            if (!empty($gap['top'])) {
                $gy = str_replace('var:preset|spacing|', '', $gap['top']);
            }
        }
    }

    // Manipulate HTML with DOMDocument
    libxml_use_internal_errors(true); //dom document expects <DOCTYPE... so it would throw errors
    $dom = new DOMDocument();
    $dom->loadHTML($block_content);
    libxml_clear_errors();

    $figures = $dom->getElementsByTagName('figure');
    if ($figures->length === 0) {
        return $block_content; // Fail gracefully
    }

    $figure = $figures->item(0);

    // Update class list
    $existing_class = $figure->getAttribute('class');
    $new_class = trim($existing_class . ' wp-block-gallery kapital-gallery gallery-with-lightbox align' . esc_attr($align));
    $figure->setAttribute('class', $new_class);

    // Extract figcaption if present
    $figcaption = null;
    foreach ($figure->childNodes as $child) {
        if ($child->nodeName === 'figcaption') {
            $figcaption = $child;
            $figure->removeChild($child);
            break;
        }
    }

    // Wrap all remaining content in masonry div
    $wrapper = $dom->createElement('div');
    $wrapper->setAttribute('class', "masonry w-100 row align-items-start gx-{$gx} gy-{$gy}");

    // Move all nodes except figcaption into masonry div
    while ($figure->hasChildNodes()) {
        $wrapper->appendChild($figure->firstChild);
    }
    $figure->appendChild($wrapper);

    // Re-append figcaption if it was removed
    if ($figcaption) {
        $figure->appendChild($figcaption);
    }

    // Return innerHTML of body
    $body = $dom->getElementsByTagName('body')->item(0);
    $new_content = '';
    foreach ($body->childNodes as $child) {
        $new_content .= $dom->saveHTML($child);
    }

    return $new_content;
}

// Register Masonry script
add_action('init', function () {
    wp_register_script(
        'kapital-gallery-masonry',
        get_template_directory_uri() . '/js/masonry.min.js',
        [],
        null,
        true
    );
});

// Attach script to core/gallery block
add_filter('block_type_metadata_settings', function ($settings, $metadata) {
    if ($metadata['name'] === 'core/gallery') {
        $settings['script'] = 'kapital-gallery-masonry';
    }
    return $settings;
}, 10, 2);
