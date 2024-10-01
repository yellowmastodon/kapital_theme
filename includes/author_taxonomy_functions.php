<?php


/* Add fields before edit term fields */

function autorstvo_edit_term_fields($term, $taxonomy)
{
    if (!empty($term)) {
        $first_name = get_term_meta($term->term_id, 'first_name', true);
        $last_name = get_term_meta($term->term_id, 'last_name', true);
        $full_name = get_term_meta($term->term_id, 'full_name', true);
        $is_custom_slug = get_term_meta($term->term_id, 'is_custom_slug', true);
        if ($is_custom_slug === "") {
            $is_custom_slug = "false";
        }
    } ?>
    <input type="hidden" id="is_custom_slug" name="is_custom_slug" value="<?php echo $is_custom_slug; ?>">
    <table class="form-table">
        <tr class="form-field">
            <th><label for="first_name">Rodné meno</label></th>
            <td>
                <input name="first_name" id="first_name" type="text" value="<?php echo esc_attr($first_name) ?>" />
                <p class="description"><?php echo __('V prípade prezývky, alebo umeleckého mena toto pole nie je potrebné.', 'kapital'); ?></p>
            </td>
        </tr>
        <tr class="form-field">
            <th><label for="last_name">Priezvisko (povinné)</label></th>
            <td>
                <input name="last_name" id="last_name" required type="text" value="<?php echo esc_attr($last_name) ?>" />
                <p class="description"><?php echo __('Podľa tohoto poľa sa generuje abecedný zoznam autorstva. V prípade prezývky/umeleckého mena použite výlučne toto pole.', 'kapital'); ?></p>
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
    ob_start()?>
    <input type="hidden" id="is_custom_slug" name="is_custom_slug" value="false">
    <div class="form-field">
        <label for="first_name"><?php echo __('Prvé meno</label>', 'kapital')?></label>
        <input name="first_name" id="first_name" type="text" value="" />
        <p class="description"><?php echo __('V prípade prezývky, alebo umeleckého mena toto pole nie je potrebné.', 'kapital'); ?></p>
    </div>
    <div class="form-field form-required">
        <label for="last_name"><?php echo __('Priezvisko (povinné)', 'kapital')?></label>
        <input name="last_name" required id="last_name" type="text" value="" />
        <p class="description"><?php echo __('Podľa tohoto poľa sa generuje abecedný zoznam autorstva. V prípade prezývky/umeleckého mena použite výlučne toto pole.', 'kapital'); ?></p>
    </div>
    <div class="form-field">
        <label for="last_name"><?php echo __('Zobrazenie celého mena', 'kapital')?></label>
        <select style="width:100%" disabled name="full_name" id="full_name">
            <option selected value=""><?php echo __('Celé meno autorstva</option>', 'kapital')?></option>
        </select>
        <p class="description"><?php echo __('V prípade mien so zaužívaným priezviskom na prvom mieste vyberte druhú možnosť.', 'kapital'); ?></p>
    </div>
    <?php

    //add closing bracket for form element and remove the last bracket
    $content = ob_get_clean();
    $last_right_bracket =strrpos($content,">");
    echo '>' . substr($content, 0, $last_right_bracket);

}
add_action('autorstvo_term_new_form_tag', 'autorstvo_add_term_fields');

/* Add styles that hide default inputs*/
function autorstvo_term_styles()
{?>
    <style>
        .term-name-wrap, .term-description-wrap{
            display: none;
        }
    </style>
<?php
}
add_action('autorstvo_add_form_fields', 'autorstvo_term_styles');
add_action('autorstvo_edit_form_fields', 'autorstvo_term_styles');


/** Enqueue script that autofills slug and other values, when editing term */
function edit_author_term_scripts() {
	$screen = get_current_screen();
    if ( $screen->id == "edit-autorstvo" ) {
        wp_enqueue_script( 'author_taxonomy_scripts', get_template_directory_uri() . '/includes/author_taxonomy_scripts.js', array(), false, array('in_footer'=> true) );
    }
}
add_action( 'admin_enqueue_scripts', 'edit_author_term_scripts', 0 );

/** register needed metadata 
 * auth_callback override needed for gutenberg
 * store as object, for single database call
*/
function register_autorstvo_meta_fields(){
    register_term_meta( 'autorstvo', '_author_name_meta', array(
        'auth_callback' => '__return_true',
        'type' => 'string',
        'single' => true,
        'show_in_rest'  => [
            true,
            'schema' => [
                'type'       => 'object',
                'properties' => [
                    'full_name' => [
                        'type' => 'string',
                    ],
                    'first_name' => [
                        'type' => 'string',
                    ],
                    'last_name' => [
                        'type' => 'string',
                    ],
                    'is_custom_slug' => [
                        'type' => 'string',
                    ],
                ],
            ],
        ],
        'type' => 'object',
        ),
    );
}
add_action( 'init', 'register_autorstvo_meta_fields');


/** save metadata  */
function author_save_term_fields( $term_id ) {

    $meta = (object)[];
    $meta->full_name = sanitize_text_field( $_POST[ 'full_name' ] );
    $meta->last_name = sanitize_text_field( $_POST[ 'last_name' ] );
    $meta->first_name = sanitize_text_field( $_POST[ 'first_name' ] );
    $meta->first_name = sanitize_text_field( $_POST[ 'is_custom_slug' ] );
	update_term_meta(
		$term_id,
		'_author_name_meta',
		$meta
	);
}
add_action( 'created_autorstvo', 'author_save_term_fields' );
add_action( 'edited_autorstvo', 'author_save_term_fields' );

/** Add full name column to taxonomy edit screen and rename "Name" to "priezvisko"(last name)*/
function add_new_autorstvo_columns($columns)
{
    $columns['name'] = __('Priezvisko', 'kapital');
    unset($columns['description']);
    $columns = array_slice($columns, 0, 1, true) +  array('full_name' => __('Celé meno', 'kapital')) + array_slice($columns, 1, NULL, true);
    return $columns;
}

/** Render "full names" from meta for each term in list of authors on edit-tags page */
function add_autorstvo_column_content($content, $column_name, $term_id)
{
    $term = get_term($term_id, 'autorstvo');
    if ($column_name == 'full_name') {
        $meta = get_term_meta($term_id, '_author_name_meta', true);
        if (isset($meta->full_name)){
            $content = $meta->full_name;
        } else {
            $content = "";
        }
    }
    return $content;
}
add_filter('manage_edit-autorstvo_columns', 'add_new_autorstvo_columns');

add_filter( 'list_table_primary_column', function(){return('full_name');}, 'edit-autorstvo' );




add_filter('quick_edit_enabled_for_taxonomy', 'disable_autorstvo_quick_edit', 10, 2);

function disable_autorstvo_quick_edit($enable, $taxonomy)
{
    if ($taxonomy == 'autorstvo') {
        return false;
    } else {
        return $enable;
    }
}

function remove_bulk_actions($actions)
{
    unset($actions['inline']);
    return $actions;
}
add_filter('bulk_actions-autorstvo', 'remove_bulk_actions');



add_filter('manage_autorstvo_custom_column', 'add_autorstvo_column_content', 10, 3);



/* function autorstvo_edit_term_data($data, $term_id, $taxonomy, $args)
{
    if ($taxonomy == 'autorstvo') {
        $first_name = $_POST['first_name'];
        $last_name =  $_POST['last_name'];
        $full_name = $first_name . ' ' . $last_name;
        $data['slug'] = sanitize_title($first_name . $last_name);
        $data['name'] = sanitize_text_field($last_name);
    }
    //wp_die(var_dump($data));
    return $data;
}
add_filter('wp_update_term_data', 'autorstvo_edit_term_slug', 10, 4); */

function autorstvo_insert_term($term, $taxonomy, $args)
{
    if ($taxonomy == 'autorstvo') {
        $first_name = $args['first_name'];
        $last_name =  $args['last_name'];
        $full_name = $first_name . ' ' . $last_name;
        $term = sanitize_text_field($last_name);
    }
    return ($term);
}
add_filter('pre_insert_term', 'autorstvo_insert_term', 10, 3);

/* function autorstvo_insert_term_data($data, $taxonomy, $args)
{

    if ($taxonomy == 'autorstvo') {
        $first_name = $_POST['first_name'];
        $last_name =  $_POST['last_name'];
        $full_name = $first_name . ' ' . $last_name;
        $term = sanitize_text_field($last_name);
        $data['slug'] = sanitize_title($first_name . $last_name);
    }
    return ($data);
    //wp_die(var_dump($data));  
} */

//add_filter('wp_insert_term_data', 'autorstvo_insert_term_data', 10, 3 );






