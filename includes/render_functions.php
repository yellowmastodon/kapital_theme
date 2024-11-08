<?php
/** Collection of various functions for rendering front end content
 */

/** Rendering any string wrapped in spans with correct classes for "bubble heading"
 * @param string $string              String to be displayed in bubble 
 * @param int $heading_level          1-6 for h1-h6.
 *                                    Defaults to 2.
 *                                    0 or any other number results in div instead of heading
 * @param string $additional_classes  pass classes as string with spaces to wrapper/heading tag  
 * @return string                     html elements for heading with children spans, if $string is empty, returns empty string
 */
function kapital_bubble_title(string $string, int $heading_level = 2, string $additional_classes = ''){

    if (!empty($string)){
        //add space before classes
        if ($additional_classes !== ''){
            $additional_classes = ' ' . $additional_classes;
        }
        //check if is heading (int 1-6)
        if (is_int($heading_level) && $heading_level > 0 && $heading_level < 7): $is_heading = true; else: $is_heading = false; endif;
        $output = '';
        $exploded_string = explode(" ", $string);

        //wrapper / heading tag start
        if ($is_heading): $output .= '<h' . $heading_level . ' class="bubble-heading' . $additional_classes . '">'; else: $output .= '<div class="bubble-heading' . $additional_classes . '">'; endif;
        foreach ($exploded_string as $span_content){
            $output .= '<span>' . $span_content . '</span>';
        }

        //wrapper / heading tag start
        if ($is_heading): $output .= '</h' . $heading_level . '>'; else: $output .= '</div>'; endif;
        return($output);
    } else {
        return('');
    }
}

function kapital_responsive_image(int $attachment_id, string $figure_classes = '', string $img_classes = ''){
    $image_sizes= get_intermediate_image_sizes($attachment_id);
    $image_sizes = $image_sizes;
    $image_sizes[] = "full";
    $attachment = get_post($attachment_id);
    $caption = $attachment->post_excerpt;
    $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
    $srcset = "";
    foreach($image_sizes as $image_size){
        if($image_size !== 'thumbnail' && $image_size !== 'placeholder'){

            //returns array of values for specific image size
            // https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
            $src = wp_get_attachment_image_src($attachment_id, $image_size);
            if ($srcset !== ''){
                $srcset .= ', ';
            }
            $srcset .= $src[0] . ' ' . $src[2] . 'w';
            //calculate aspect ratio for placeholder
            if ($image_size === "full"){
                $aspect_ratio = $src[1] / $src[2];
            }
        }
    }
    //also include full size image



    ?>
    <figure class="<?php echo $figure_classes?>">
            <img srcset="<?php echo $srcset?>"
            class="<?php echo $img_classes?>"
            style="background-image: url('<?php echo wp_get_attachment_image_src($attachment_id, 'placeholder')[0];?>'); aspect-ratio: <?php echo $aspect_ratio ?>"
            src="<?php echo wp_get_attachment_image_src($attachment_id, 'full_size')[0]?>"
            sizes="(min-width: 900px) 900px, 100%"
            loading="lazy"
            alt="<?php echo $alt; ?>"/>
        <?php if ($caption !== ""):?>
            <figcaption class="fs-small alignnormal mt-1 ff-sans text-gray text-center">
                <?php echo $caption;?>
            </figcaption>
        <?php endif?>
    </figure>
    <?php

}