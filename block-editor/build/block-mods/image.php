<?php

/**
 * Custom image block rendering
 * Primary reason is to set correct sizes attribute based on context
 * Adds custom lightbox support if parent is gallery
 */


add_filter('pre_render_block', 'kapital_render_image', 11, 3);

function kapital_render_image($pre_render, $block, $parent_block)
{
    if ($block['blockName'] !== 'core/image') return null;
    $attributes = $block['attrs'];


    if (!is_null($parent_block) && isset($parent_block->parsed_block)) {
        $parent_block = $parent_block->parsed_block;
    } else {
        $parent_block = false;
    }

    $image_classnames = '';
    $image_html_id = '';
    $figcaption = null;

    //hackish extracting classes and id
    if (isset($block['innerHTML']) && $block['innerHTML'] !== "") {

        // Extract class
        if (preg_match('/class="([^"]+)"/', $block['innerHTML'], $class_matches)) {
            $image_classnames = $class_matches[1];

            //remove size-* classes
            $filtered_classes = explode(' ', $image_classnames);
            $filtered_classes = array_filter($filtered_classes, function ($class) {
                return strpos($class, 'size-') !== 0;
            });
            $image_classnames = implode(' ', $filtered_classes);
        }

        // Extract ID
        if (preg_match('/id="([^"]+)"/', $block['innerHTML'], $id_matches)) {
            $image_html_id = $block['attrs']['htmlId'] = $id_matches[1] ?? '';
        }

        // setup custom figcaption, if entered from block
        if (str_contains($block["innerHTML"], '<figcaption')) {
            if (preg_match('/<figcaption[^>]*>(.*?)<\/figcaption>/is', $block["innerHTML"], $figcaption_matches)) {
                $figcaption = $figcaption_matches[1];
            }
        }
    }






    $has_id_binding = isset($attributes['metadata']['bindings']['id']) && isset($attributes['id']);

    //do not render block if no image selected
    if (isset($attributes["id"]) && $attributes["id"]) {
        $attachment_id = $attributes["id"];
    } else {
        return '';
    }



    // Ensure the `wp-image-id` classname on the image block supports block bindings.
    if ($has_id_binding) {
        // If there's a mismatch with the 'wp-image-' class and the actual id, the id was
        // probably overridden by block bindings. Update it to the correct value.
        // See https://github.com/WordPress/gutenberg/issues/62886 for why this is needed.
        $id                       = $attachment_id;
        $image_classnames         .= $attributes['className'];
        $class_with_binding_value = "wp-image-$id";
        if (is_string($image_classnames) && ! str_contains($image_classnames, $class_with_binding_value)) {
            $image_classnames = preg_replace('/wp-image-(\d+)/', $class_with_binding_value, $image_classnames);
        }
    }
    
    $size_slug = 'large';
    if (isset($attributes['sizeSlug'])){
        $size_slug = $attributes['sizeSlug'];
    }

    //setup margin classes 
    if (isset($attributes["style"]["spacing"]["margin"])) {
        $margin_style = '';
        foreach (array('top' => 'mt-', 'bottom' => 'mb-', 'left' => 'ms-', 'right' => 'me-') as $m_dir_key => $m_dir_class) {
            if (isset($attributes["style"]["spacing"]["margin"][$m_dir_key])) {
                if (str_contains($attributes["style"]["spacing"]["margin"][$m_dir_key], 'var:preset|spacing|')){
                    $image_classnames .= ' ' . $m_dir_class . str_replace('var:preset|spacing|', '', $attributes["style"]["spacing"]["margin"][$m_dir_key]);
                } else {
                    $margin_val = $attributes["style"]["spacing"]["margin"][$m_dir_key];
                    $margin_style .= "margin-{$m_dir_key}:{$margin_val};";
                }
            }
        }
        //stupid way to insert style - break classes declaration with " "
        if ($margin_style !== ''){
            $image_classnames = $image_classnames . '" style="' . $margin_style;
        }
    }

    //add align class and calculate sizes based on parent block and width
    $link_destination  = (isset($attributes['linkDestination']) && $attributes['linkDestination'] !== 'none') ? $attributes['linkDestination'] : '';

    if (!$parent_block) {
        //default size for alignnormal
        //if align set
        $sizes = '(max-width: 600px) 95vw, (max-width: 1649px) 600px, (max-width: 1919px) 700px, 800px';
        if (isset($attributes['align'])) {
            switch ($attributes['align']) {
                case 'wide':
                    $sizes = '(max-width: 900px) 95vw, (max-width: 1649px) 800px, (max-width: 1919px) 900px, 1000px';
                    break;
                case 'full':
                    $sizes = '100vw';
                    break;
                //align: center, left, right
                default:
                    $default_max_size = kapital_image_determine_sizes_attr_by_slug($size_slug);
                    $sizes = "(max-width: {$default_max_size}px) 95vw, {$default_max_size}px";
            }
            //default size "alignnormal"
        }
        return sprintf(
            '%s%s%s',
            $link_destination !== '' ? "<a class=\"d-block\" href=\"$link_destination\">" : '',
            kapital_responsive_image($attachment_id, $sizes, true, '', $image_classnames, "", $image_html_id, $figcaption),
            $link_destination !== '' ? "</a>" : ''
        );

        
    } else if ($parent_block["blockName"] === "core/gallery") {
        $parent_attributes = $parent_block["attrs"];
        //default columns is 3
        $parent_columns = 3;
        if (isset($parent_attributes["columns"])) {
            $parent_columns = (int)$parent_attributes["columns"];
        }
        //default align is full
        $parent_align = 'full';
        if (isset($parent_attributes["align"])) {
            $parent_align = $parent_attributes["align"];
            if ($parent_align === '') {
                $parent_align = 'normal';
            }
        }
        //default sizes attr
        $sizes = '30vw';
        switch ($parent_align) {
            case 'normal':
                $size_n1 = intdiv(600, $parent_columns);
                $size_n2 = intdiv(700, $parent_columns);
                $size_n3 = intdiv(800, $parent_columns);
                $sizes = "(max-width: 600px) 95vw, (max-width: 1649px) {$size_n1}px, (max-width: 1919px) {$size_n2}px, {$size_n2}px";
                break;
            case 'wide':
                $size_n1 = intdiv(800, $parent_columns);
                $size_n2 = intdiv(900, $parent_columns);
                $size_n3 = intdiv(1000, $parent_columns);
                $sizes = "(max-width: 900px) 95vw, (max-width: 1649px) {$size_n1}px, (max-width: 1919px) {$size_n2}px, {$size_n3}px";
                break;
            default:
                $size_n = intdiv(95, $parent_columns);
                $sizes = "(max-width: 600px) 95vw, {$size_n}vw";
        }

        $col_size = intdiv(12, $parent_columns);
        
        ob_start();
        ?>
        <div class="col-masonry col-12 col-sm-<?=$col_size?>">
            <?php get_template_part('template-parts/gallery-lightbox-toggle-wrap', null, ['html'=>kapital_responsive_image($attachment_id, $sizes, false, "$image_classnames w-100", '', "", $image_html_id)])?>
        </div>
        <?php
        $out = ob_get_clean();
        return $out;
    }


    //fallback
    return null;
}

function kapital_image_determine_sizes_attr_by_slug($size_slug)
{
    static $registered_image_sizes;
    if (!isset($registered_image_sizes)) {
        $registered_image_sizes = wp_get_registered_image_subsizes();
    }
    //render largest possible version
    if ($size_slug === 'full') {
        return '100vw';
    } else {
        return $registered_image_sizes[$size_slug]["width"];
    }
}
