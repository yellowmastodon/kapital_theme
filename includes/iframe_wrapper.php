<?php
/** iframe wrapper needed for complianz placeholder */

add_filter('the_content', 'sandbox_iframes', 20, 1);

function sandbox_iframes( $content ) {
    $content = preg_replace( '/(<iframe[\s\S]*?<\/iframe>)/', '<div>$1</div>', $content );
    return $content;
}