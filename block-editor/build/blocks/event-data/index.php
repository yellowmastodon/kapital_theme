<?php 
/**
 * Registers the `kapital/event-data` block on the server.
 * Limits registration to custom post type "event"
 */

add_action('init', 'maybe_register_event_data_block');
function maybe_register_event_data_block()
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
    if ($typenow != 'event') {
      return;
    }
  }

  // Register the block
    register_block_type(
        __DIR__
    );
}

foreach (
  array(
    '_event_date_start',
    '_event_date_end',
    '_event_date_string', //human readable date and its format in stringified object
    '_event_location' //event location in stringified object with url and richtext
  ) as $meta_key
) {
  $type = ($meta_key === '_event_date_start' || $meta_key === '_event_date_end') ? 'integer' : 'string';
  register_post_meta('event', $meta_key, array(
    'auth_callback' => function () {
      return current_user_can('edit_posts');
    },
    'show_in_rest'  => [
      true,
      'schema' => [
        'type'       => $type,
      ],
    ],
    'single' => true,
    'type' => $type,
  ));
}