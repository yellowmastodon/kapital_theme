<?php

/**
 * Wrap all core/paragraph blocks in a <div>.
 *
 * @param  string    $block_content HTML markup of the block
 * @param  WP_Block  $block         Block Class instance
 * @return string                   Modified block content
 */
function kapital_button_filter( $block_content, $block ) {
    if (isset($block["attrs"]["icon"]) ){
        $icon = $block["attrs"]["icon"];
    } else {
        $icon = "";
    }
    if (isset($block["attrs"]["iconAlign"]) ){
        $icon_align = $block["attrs"]["iconAlign"];
    } else {
        $icon_align = "icon-right";
    }
    if (isset($block["attrs"]["backgroundColor"]) ){
        $background_color = $block["attrs"]["backgroundColor"];
    } else {
        $background_color = "";
    }
    $link = array();
    $target = array();
    preg_match('/href="([\s\S]*?)"/', $block["innerHTML"], $link);
    if (count($link) > 0){
        $link = $link[1];
    } else {
        $link = "";
    }
    preg_match('/target="[\s\S]*?"/', $block["innerHTML"], $target);
    if (!empty($target)){
        $target = ' ' . $target[0];
    } else {
        $target = '';
    }
    $inner_content = trim(strip_tags($block["innerHTML"]));

    $link;
    $content  = '<a href="' . $link . '"' . $target . ' class="btn';
    if ($background_color === 'red'){
        $content .= ' btn-red';
    } elseif ($background_color === 'pink'){
        $content .= ' btn-primary';
    } elseif ($background_color === '' || $background_color === 'gray-light'){
        $content .= ' btn-secondary';
    } else {
        $content .= ' has-' . $background_color . 'background-color';
    }
    $content .= '">';
    if ($icon_align === "icon-left" && $icon !== ""){
        $content .= '<svg class="me-2 icon-square"><use xlink:href="#' . $icon . '"></use></svg>';
    }
    $content .= $inner_content;
    if ($icon_align === "icon-right" && $icon !== ""){
        $content .= '<svg class="ms-2 icon-square"><use xlink:href="#' . $icon . '"></use></svg>';
    }
    $content .= '</a>';
     
    return $content;
}
add_filter( 'render_block_core/button', 'kapital_button_filter', 10, 2 );
