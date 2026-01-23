<?php 
// Custom PHP rendering for the heading block variation
function bubble_heading_variation($block_content, $block) {
    
    // Check if the block is a core/heading block
    preg_match('/class="([^"]*)"/', $block_content, $classname_match);
    if (isset($classname_match[1]) && $classname_match[1]){
        $classnames = $classname_match[1];
    }
    if ('core/heading' === $block['blockName']) {
        // Get the block's attributes (including the variation)
        if (isset($block['attrs']["level"])){
            $level = $block['attrs']["level"];
        } else {
            $level = 2;
        }
        $content = strip_tags($block["innerHTML"]);
        // Check for large-heading variation
        if (isset($block['attrs']['className']) && strpos($block['attrs']['className'], 'bubble-heading') !== false) {
            // Change the level and classes as needed for large-heading variation
            $block_content = kapital_bubble_title($content, $level, $classnames);
        }
    }

    return $block_content;
}
add_filter('render_block_core/heading', 'bubble_heading_variation', 10, 2); 