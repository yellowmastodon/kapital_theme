<?php 
/**
 * Registers the `kapital/podcast-links` block on the server.
 * Limits registration to custom post type "podcast"
 */

add_action('init', 'maybe_register_podcast_links_block');
function maybe_register_podcast_links_block()
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
    if ($typenow != 'podcast') {
      return;
    }
  }

  // Register the block
    register_block_type(
        __DIR__
    );
}


register_post_meta( 'podcast', '_podcast_links', array(
    'auth_callback' => function() { 
        return current_user_can( 'edit_posts' );
    },
    'show_in_rest'  => [
        true,
        'schema' => [
            'type'       => 'string',
        ],
    ],
    'single' => true,
    'type' => 'string',
) );