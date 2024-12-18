<?php 
add_action( 'admin_init', 'kapital_product_repeater_meta_boxes' );

function kapital_product_repeater_meta_boxes() {
	add_meta_box( 'kapital-book-author', __('Autorstvo knihy a poznámka produktu', 'kapital'), 'kapital_book_author_meta_box_callback', 'product', 'after_title', 'high' );
}

function kapital_book_author_meta_box_callback( $post ){
    $kapital_book_author = get_post_meta( $post->ID, '_kapital_book_author', true );
    $kapital_product_notice = get_post_meta( $post->ID, '_kapital_product_notice', true );
    wp_nonce_field( 'repeater_box', 'formType' );?>
    <table style="width:100%">
        <tr>
     <th  style="text-align: left; vertical-align: top"><label for="kapital_book_author"><?=__("Autorstvo knihy", "kapital")?></th><td style="width:70%"><input style="width:100%" type="text" name="kapital_book_author"  id="kapital_book_author" value="<?=$kapital_book_author?>" placeholder="<?=__("Meno autora. Ak sa nejedná o knihu, nechajte prázdne.", "kapital")?>"></td>
    </tr>    
    <tr>
     <th  style="text-align: left; vertical-align: top"><label for="kapital_product_notice"><?=__("Poznámka k produktu (napr. dátum vydania pri predpredaji)", "kapital")?></th><td><textarea style="width:100%" name="kapital_product_notice" rows="5" id="kapital_product_notice"><?= $kapital_product_notice?></textarea></td>
    </tr>    
</table>
    <?php
}
add_action( 'save_post', 'kapital_book_author_meta_box_save' );
function kapital_book_author_meta_box_save( $post_id ) {
	if ( !isset( $_POST['formType'] ) && !wp_verify_nonce( $_POST['formType'], 'book_author' ) ){
		return;
	}
    if ( isset( $_POST['kapital_book_author'] ) ){
        update_post_meta( $post_id, '_kapital_book_author', $_POST['kapital_book_author'] );
    }
    if ( isset( $_POST['kapital_product_notice'] ) ){
        update_post_meta( $post_id, '_kapital_product_notice', $_POST['kapital_product_notice'] );
    }
}

function edit_form_after_title() {
    // get globals vars
    global $post, $wp_meta_boxes;

    do_meta_boxes( get_current_screen(), 'after_title', $post );

    // unset 'ai_after_title' context from the post's meta boxes
    unset( $wp_meta_boxes['post']['after_title'] );
}
add_action( 'edit_form_after_title', 'edit_form_after_title' );




function custom_product_search_query( $search, $query_vars ) {
    global $wpdb;
    if(isset($query_vars->query['s']) && !empty($query_vars->query['s'])){
        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
            'meta_query' => array(
                array(
                    'key' => '_kapital_book_author',
                    'value' => $query_vars->query['s'],
                    'compare' => 'LIKE'
                )
            )
        );
        $posts = get_posts($args);
        if(empty($posts)) return $search;
        $get_post_ids = array();
        foreach($posts as $post){
            $get_post_ids[] = $post->ID;
        }
        if(sizeof( $get_post_ids ) > 0 ) {
                $search = str_replace( 'AND (((', "AND ((({$wpdb->posts}.ID IN (" . implode( ',', $get_post_ids ) . ")) OR (", $search);
        }
    }
    return $search;
    
}
    add_filter( 'posts_search', 'custom_product_search_query', 999, 2 );

?>