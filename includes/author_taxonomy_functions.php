<?php


/* Add fields before edit term fields */

function autorstvo_edit_term_fields($term, $taxonomy)
{
    //not sure if this term can happen to be empty in this context, but just to be sure;
    if (!empty($term)) {
        $meta = get_term_meta($term->term_id, '_author_name_meta', true);
        $full_name = get_term_meta($term->term_id, '_author_full_name', true);
        $first_name = $meta->first_name;
        //we saved last name as term name in db, so we can use thaat
        $last_name = $term->name;
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

        .term-name-wrap,
        .term-description-wrap {
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
        '_author_name_meta',
        array(
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            },
            'single' => true,
            'show_in_rest'  => [
                true,
                'schema' => [
                    'type'       => 'object',
                    'properties' => [
                        'first_name' => [
                            'type' => 'string',
                        ],
                        'last_name' => [
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
            'type' => 'object',
        ),
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
}
add_action('init', 'register_autorstvo_meta_fields');


/** save metadata  */
function author_save_term_fields($term_id)
{
    $meta = (object)[];
    $full_name = sanitize_text_field($_POST['full_name']);
    $meta->last_name = sanitize_text_field($_POST['last_name']);
    $meta->first_name = sanitize_text_field($_POST['first_name']);
    update_term_meta(
        $term_id,
        '_author_name_meta',
        $meta
    );
    update_term_meta(
        $term_id,
        '_author_full_name',
        $full_name
    );
}
add_action('created_autorstvo', 'author_save_term_fields');
add_action('edited_autorstvo', 'author_save_term_fields');

/** Add full name column to taxonomy edit screen and rename "Name" to "priezvisko"(last name)*/
function add_new_autorstvo_columns($columns)
{
    $columns['name'] = __('Priezvisko', 'kapital');
    unset($columns['description']);
    $columns = array_slice($columns, 0, 1, true) +  array('full_name' => __('Celé meno', 'kapital')) + array_slice($columns, 1, NULL, true);
    return $columns;
}
add_filter('manage_edit-autorstvo_columns', 'add_new_autorstvo_columns');



/** Render "full names" from meta for each term in list of authors on edit-tags page */
function add_autorstvo_column_content($content, $column_name, $term_id)
{
    if ($column_name == 'full_name') {
        $full_name = get_term_meta($term_id, '_author_full_name', true);
        if (isset($full_name)) {
            $content = '<a href="' . get_edit_term_link($term_id, 'autorstvo', 'post') . '"><strong>' . $full_name . '</strong></a>';
        } else {
            $content = "";
        }
    }
    return $content;
}
add_filter('manage_autorstvo_custom_column', 'add_autorstvo_column_content', 10, 3);

/** Render "full names" from meta for each post in list */

function add_autorstvo_column_content_post($term_links, $taxonomy, $terms)
{
     /* This function filters all the taxonomies in all post lists, so only edit yours */
     if ($taxonomy === 'autorstvo' && is_array( $terms ) ) {
        $term_links = array();
        foreach ( $terms as $t ) {
            $term_name = get_term_meta($t->term_id, '_author_full_name', true); // modify term name as you want
            
            $term_link_params = array(
                'post_type' => 'post', /* CHANGE to 'post'/'page' or any CPT */
                $t->taxonomy => $t->slug,
            );
            $term_link = add_query_arg( $term_link_params, 'edit.php' );

            $term_links[] = sprintf( '<a href="%s">%s</a>', $term_link, $term_name );
        }
        return $term_links;
    }

    /* Return all others */
    return $term_links;
}
add_filter('post_column_taxonomy_links', 'add_autorstvo_column_content_post', 10, 3);

//Set full name as primary column (contains links - edit, delete)
add_filter('list_table_primary_column', function () {
    return ('full_name');
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

/** Set term name to last name before saving to database */
function autorstvo_insert_term($term, $taxonomy, $args)
{
    if ($taxonomy == 'autorstvo') {
        $last_name =  $args['last_name'];
        $term = sanitize_text_field($last_name);
    }
    return ($term);
}
add_filter('pre_insert_term', 'autorstvo_insert_term', 10, 3);

/** Remove default author support */
function remove_default_author_support()
{
    foreach (array('podcast', 'redakcia', 'post', 'page') as $post_type) {
        remove_post_type_support("{$post_type}", 'author');
    }
}
add_action('init', 'remove_default_author_support');
