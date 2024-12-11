<?php 
/**
 * Registers the `kapital/donation-form` block on the server.
 * Limits registration to custom post type "podcast"
 */

add_action('init', 'maybe_register_donation_form_block');
function maybe_register_donation_form_block()
{
  // Check if this is the intended custom post type
  if (is_admin()) {
    global $pagenow;
    $typenow = '';
    if ( 'post-new.php' === $pagenow ) {
      if ( isset( $_REQUEST['post_type'] ) && post_type_exists( $_REQUEST['post_type'] ) ) {
        $typenow = $_REQUEST['post_type'];
      };
    } elseif ( 'post.php' === $pagenow ) {
      if ( isset( $_GET['post'] ) && isset( $_POST['post_ID'] ) && (int) $_GET['post'] !== (int) $_POST['post_ID'] ) {
        // Do nothing
      } elseif ( isset( $_GET['post'] ) ) {
        $post_id = (int) $_GET['post'];
      } elseif ( isset( $_POST['post_ID'] ) ) {
        $post_id = (int) $_POST['post_ID'];
      }
      if ( $post_id ) {
        $post = get_post( $post_id );
        $typenow = $post->post_type;
      }
    }
    //podcast and post handle insertion automatically
    if ($typenow == 'podcast' || $typenow == 'post') {
      //return;
      register_block_type(
        __DIR__
    );
    }
  }

  // Register the block
    register_block_type(
        __DIR__
    );
}