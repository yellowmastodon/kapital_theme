<?php


/* Add fields before edit term fields */

function autorstvo_edit_term_fields($term, $taxonomy)
{
    //not sure if this term can happen to be empty in this context, but just to be sure;
    if (!empty($term)) {
        $full_name = $term->name;
        $first_name = get_term_meta($term->term_id, '_author_first_name', true);
        //we saved last name as term name in db, so we can use thaat
        $last_name = get_term_meta($term->term_id, '_author_last_name', true);
        $slug = $term->slug;
    } else {
        $first_name = '';
        $last_name = '';
        $full_name = '';
        $slug = '';
    }
    //set custom slug fixed for edit to not change the url
    $is_custom_slug = false;

    //custom_slug checkbox hidden, just for javascript control 
?>
    <input type="checkbox" id="is_custom_slug" name="is_custom_slug" style="display:none" <?php echo ($is_custom_slug) ? 'checked' : ''; ?>>
    <table class="form-table">
        <tr class="form-field">
            <th><label for="first_name"><?php echo __('Rodné meno', 'kapital'); ?></label></th>
            <td>
                <input name="first_name" id="first_name" type="text" value="<?php echo esc_attr($first_name) ?>" />
                <p class="description"><?php echo __('V prípade prezývky, alebo umeleckého mena toto pole nie je potrebné.', 'kapital'); ?></p>
            </td>
        </tr>
        <tr class="form-field">
            <th><label for="last_name"><?php echo __('Priezvisko (povinné)', 'kapital'); ?></label></th>
            <td>
                <input name="last_name" id="last_name" required type="text" value="<?php echo esc_attr($last_name) ?>" />
                <p class="description"><?php echo __('Podľa tohoto poľa sa generuje abecedný zoznam autorstva. V prípade prezývky/umeleckého mena použite výlučne toto pole.', 'kapital'); ?></p>
            </td>
        </tr>
        <tr class="form-field">
            <th><label for="last_name"><?php echo __('Zobrazenie celého mena', 'kapital'); ?></label></th>
            <td>
                <select style="width:100%" <?php echo (empty($first_name) || empty($last_name) || empty($full_name)) ? 'tabindex="-1" class="disabled"' : ''; ?> name="full_name" id="full_name">
                    <?php if (empty($full_name || empty($last_name))): ?>
                        <option selected value=""><?php echo __('Celé meno autorstva</option>', 'kapital') ?></option>
                    <?php elseif (empty($first_name)): ?>
                        <option selected value="<?php echo $last_name ?>"><?php echo $last_name; ?></option>
                    <?php elseif (str_starts_with($full_name, $first_name)): ?>
                        <option selected value="<?php echo $first_name . ' ' . $last_name; ?>"><?php echo $first_name . ' ' . $last_name; ?></option>
                        <option value="<?php echo $last_name . ' ' . $first_name; ?>"><?php echo $last_name . ' ' . $first_name; ?></option>
                    <?php else: ?>
                        <option value="<?php echo $first_name . ' ' . $last_name; ?>"><?php echo $first_name . ' ' . $last_name; ?></option>
                        <option selected value="<?php echo $last_name . ' ' . $first_name; ?>"><?php echo $last_name . ' ' . $first_name; ?></option>
                    <?php endif; ?>
                </select>
            </td>
        </tr>

    </table>
<?php
}
add_action('autorstvo_term_edit_form_top', 'autorstvo_edit_term_fields', 10, 2);

/* Add field before new term fields
* hackish solution, fires inside <form tag, so we close it, then leave unclosed tag at the end
*/

function autorstvo_add_term_fields($taxonomy)
{
    ob_start() ?>
    <input type="checkbox" id="is_custom_slug" name="is_custom_slug" style="display:none">
    <div class="form-field">
        <label for="first_name"><?php echo __('Prvé meno</label>', 'kapital') ?></label>
        <input name="first_name" id="first_name" type="text" value="" />
        <p class="description"><?php echo __('V prípade prezývky, alebo umeleckého mena toto pole nie je potrebné.', 'kapital'); ?></p>
    </div>
    <div class="form-field form-required">
        <label for="last_name"><?php echo __('Priezvisko (povinné)', 'kapital') ?></label>
        <input name="last_name" required id="last_name" type="text" value="" />
        <p class="description"><?php echo __('Podľa tohoto poľa sa generuje abecedný zoznam autorstva. V prípade prezývky/umeleckého mena použite výlučne toto pole.', 'kapital'); ?></p>
    </div>
    <div class="form-field">
        <label for="last_name"><?php echo __('Zobrazenie celého mena', 'kapital'); ?></label>
        <select style="width:100%" class="disabled" tabindex="-1" name="full_name" id="full_name">
            <option selected value=""><?php echo __('Celé meno autorstva</option>', 'kapital') ?></option>
        </select>
        <p class="description"><?php echo __('V prípade mien so zaužívaným priezviskom na prvom mieste vyberte druhú možnosť.', 'kapital'); ?></p>
    </div>
<?php

    //add closing bracket for form element and remove the last bracket
    $content = ob_get_clean();
    $last_right_bracket = strrpos($content, ">");
    echo '>' . substr($content, 0, $last_right_bracket);
}
add_action('autorstvo_term_new_form_tag', 'autorstvo_add_term_fields');

/* Add styles that hide default inputs*/
function autorstvo_term_styles()
{ ?>
    <style>
        .disabled {
            pointer-events: none;
        }

        .term-name-wrap {
            display: none;
        }
    </style>
<?php
}
add_action('autorstvo_add_form_fields', 'autorstvo_term_styles');
add_action('autorstvo_edit_form_fields', 'autorstvo_term_styles');


/** Enqueue script that autofills slug and other values, when editing term */
function edit_author_term_scripts()
{
    $screen = get_current_screen();
    if ($screen->id == "edit-autorstvo") {
        wp_enqueue_script('author_taxonomy_scripts', get_template_directory_uri() . '/includes/author_taxonomy_scripts.js', array(), false, array('in_footer' => true));
    }
}
add_action('admin_enqueue_scripts', 'edit_author_term_scripts', 0);

/** register needed metadata 
 * auth_callback override needed for gutenberg
 * store as object, for single database call
 */
function register_autorstvo_meta_fields()
{
    register_term_meta(
        'autorstvo',
        '_author_first_name',
        array(
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            },
            'single' => true,
            'show_in_rest'  => array(
                true,
                'type' => 'string'
            )
        )
    );
    register_term_meta(
        'autorstvo',
        '_author_full_name',
        array(
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            },
            'single' => true,
            'show_in_rest'  => array(
                true,
                'type' => 'string'
            )
        )
    );
    register_term_meta(
        'autorstvo',
        '_author_last_name',
        array(
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            },
            'single' => true,
            'show_in_rest'  => array(
                true,
                'type' => 'string'
            )
        )
    );


}
add_action('init', 'register_autorstvo_meta_fields');


/** save metadata  */
function author_save_term_fields($term_id)
{
    $meta = (object)[];
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    update_term_meta(
        $term_id,
        '_author_first_name',
        $first_name
    );
    update_term_meta(
        $term_id,
        '_author_last_name',
        $last_name
    );
}
add_action('created_autorstvo', 'author_save_term_fields');
add_action('edited_autorstvo', 'author_save_term_fields');

/** Rename 'name' column and remove description */
function add_new_autorstvo_columns($columns)
{   
    $columns = array_slice($columns, 0, 2, true) +  array('last_name' => __('Priezvisko', 'kapital')) + array_slice($columns, 2, NULL, true);
    $columns['name'] = __('Celé meno', 'kapital');
    unset($columns['description']);
    return $columns;
}
add_filter('manage_edit-autorstvo_columns', 'add_new_autorstvo_columns');

/** Add the data to the custom columns for the inzercia (ads) post type */
function kapital_sortable_author_custom_columns( $columns ) {
    unset($columns["name"]);
    $columns['last_name'] = 'last_name';
    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
 
    return $columns;
}
add_filter( 'manage_edit-autorstvo_sortable_columns', 'kapital_sortable_author_custom_columns' );


/** Query by ad start date and ad end date (end date is the same as default date) */
function kapital_sort_by_last_name(WP_Term_Query $query){
    global $pagenow;
    $taxonomies = (array) $query->query_vars['taxonomy'];
    $order_by = $query->query_vars["orderby"];
    if ( in_array( 'autorstvo', $taxonomies, true) && count($taxonomies) === 1)  {
        /* if ( empty( $order_by ) || $order_by === "name" || $order_by === "last_name"){
            $order_by = 'last_name';
        } */
        $query->query_vars['meta_key'] = '_author_last_name';
        $query->query_vars['orderby']  = 'meta_value';
    }
    /* 
    if ( !is_admin() || $pagenow !== 'edit-tags.php' )
        return;
    $taxonomy = $query->query_vars["taxonomy"];
    $order_by = $query->query_vars["orderby"];

    if ( $taxonomy === 'autorstvo' ) {
        if ( empty( $order_by ) )
            $order_by = 'last_name';
        
        switch ( $order_by ) {
            case 'last_name':
                $query->set( 'meta_key', 'last_name' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'ignore_custom_sort', true );
                break;
        }
    } */
}

add_action( 'parse_term_query', 'kapital_sort_by_last_name', 10, 1);



/** Render "last names" from meta for each term in list of authors on edit-tags page */
function add_autorstvo_column_content($content, $column_name, $term_id)
{
    if ($column_name == 'last_name') {
        $last_name = get_term_meta($term_id, '_author_last_name', true);
        if (isset($last_name)) {
            $content = '<a href="' . get_edit_term_link($term_id, 'autorstvo', 'post') . '"><strong>' . $last_name . '</strong></a>';
        } else {
            $content = "";
        }
    }
    return $content;
}
add_filter('manage_autorstvo_custom_column', 'add_autorstvo_column_content', 10, 3);


//Set full name as primary column (contains links - edit, delete)
add_filter('list_table_primary_column', function () {
    return ('name');
}, 'edit-autorstvo');

//Disable quick edit

function disable_autorstvo_quick_edit($enable, $taxonomy)
{
    if ($taxonomy == 'autorstvo') {
        return false;
    } else {
        return $enable;
    }
}
add_filter('quick_edit_enabled_for_taxonomy', 'disable_autorstvo_quick_edit', 10, 2);


function remove_bulk_actions($actions)
{
    unset($actions['inline']);
    return $actions;
}
add_filter('bulk_actions-autorstvo', 'remove_bulk_actions');

/** Set term name to full name before saving to database */
 function autorstvo_insert_term($term, $taxonomy, $args)
{
    if ($taxonomy == 'autorstvo') {
        $full_name =  $args['full_name'];
        $term = sanitize_text_field($full_name);
    }   
    //wp_die($args);
    return $term;
}
add_filter('pre_insert_term', 'autorstvo_insert_term', 10, 3);


//add_filter( 'ajax_term_search_results', 'meta_search_authors' );
//add_action( 'pre_get_terms', 'autorstvo_pre_get_terms' );
//add_action( 'pre_get_terms', 'autorstvo_pre_get_terms');

/** *//* 
function autorstvo_pre_get_terms( $wp_term_query ) {
    $taxonomy = $wp_term_query->query_vars['taxonomy'];
    //wp_die(var_dump($wp_term_query));
    $search = $wp_term_query->query_vars['search'] ?? '';

    if ( ! $search || $taxonomy !== [ 'autorstvo' ] ) {
        return;
    }

    unset( $wp_term_query->query_vars['search'] );

    $meta_query = [
        'relation' => 'OR',
    ];

    $search_meta_keys = [
        '_author_full_name',
        // Add your other meta keys
    ];

    foreach ( $search_meta_keys as $key ) {
        $meta_query[] = [
            'key' => $key,
            'value' => $search,
            'compare' => 'LIKE',
        ];
    }
    $wp_term_query->query_vars['meta_query'] = $meta_query;
};
 */

/** Remove default author support */
function remove_default_author_support()
{
    foreach (array('podcast', 'redakcia', 'post', 'page') as $post_type) {
        remove_post_type_support("{$post_type}", 'author');
    }
}
add_action('init', 'remove_default_author_support');
