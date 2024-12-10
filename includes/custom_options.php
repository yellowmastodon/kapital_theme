<?php
// create custom plugin settings menu
add_action('admin_menu', 'create_post_filter_submenu_page');

function create_post_filter_submenu_page() {
	//create new submenu
	add_submenu_page('edit.php', __('Filtre článkov', 'kapital'), __('Filtre článkov', 'kapital'), 'administrator', 'post-filters', 'kapital_post_filter_page');
	//call register settings function
	add_action( 'admin_init', 'register_posts_filter_setting' );
}

function register_posts_filter_setting() {
	//register our settings
	register_setting( 'kapital_post_filters', 'kapital_post_filters',
    array(
        'show_in_rest' => array(
            true,
            'schema' => array(
                'items' => array(
                    'type' => 'array'
                )
        )),
        'type' => 'array',
        'default' => [],
        ) );
}

function kapital_post_filter_page() {
?>
<div class="wrap">
    <style>
        .filter-item{
            padding: 8px 16px;
            border-radius: 9999px;
            border: solid 1px #8c8f94;
            background-color: white;
            text-align: center;
        }
        .filter-row td{
            padding: 4px;
        }
        .filter-row td:first-of-type{
            padding-left: 0px !important;
        }
        .filter-row a{
            color: #3c434a;
        }
        .filter-row a{
            cursor: pointer;
        }
        .filter-row .item-delete{
            text-decoration: underline;
            color: #b32d2e;
        }
        .no-items.false{
            display: none;
        }
        #filter-list td{
            display: table-cell !important;
        }
    </style>
<h1><?php echo __('Filtre článkov', 'kapital')?></h1>

<form method="post" action="options.php">
    <?php settings_fields( 'kapital_post_filters' ); ?>
    <?php do_settings_sections( 'kapital_post_filters' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Filtre</th>
        <td >
            <table>
                <?php $post_filters = get_option( 'kapital_post_filters', array());?>

                <tbody id="filter-list" class="filter-list">
                <tr class="filter-row no-items<?php if(!empty($post_filters)) echo ' false';?>">
                    <td>Nenašli sa žiadne filtre.</td>
                </tr>
                
                <?php if(!empty($post_filters)):
                    foreach ($post_filters as $post_filter):?>
                        <tr class="filter-row">
                            <input type="hidden" name="kapital_post_filters[]" value="<?php echo $post_filter?>"/>
                            <td><div class="filter-item"><?php echo get_term($post_filter)-> name?></div></td>
                            <td><a href="" class="dashicons move-down dashicons-arrow-down-alt2"></a></td>
                            <td><a href="" class="dashicons move-up dashicons-arrow-up-alt2"></a></td>
                            <td><a href="" class="item-delete">Odstrániť filter</a></td>
                        </tr>
                    <?php endforeach;
                endif;?>
                </tbody>
            </table>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Pridať filter</th>
        <td><select id="filter-select">
            <option value disabled selected>Vyberte filter</option>
            <?php $custom_taxonomies = ['seria', 'zaner', 'rubrika'];
            $filtered_terms = get_and_reorganize_terms( null , $custom_taxonomies);
            foreach($custom_taxonomies as $custom_taxonomy):?>
                <optgroup label="<?php echo get_taxonomy($custom_taxonomy)->label?>">
                    <?php foreach($filtered_terms[$custom_taxonomy] as $term):?>
                    <option value="<?php echo $term->term_id;?>"><?php echo $term->name?></option>
                    <?php endforeach;?>
                </optgroup>
            <?php endforeach;?>
        </select>      
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<script>
    const selectElement = document.getElementById("filter-select");
    const filterList = document.getElementById("filter-list");
    let noItems = filterList.querySelector(".no-items");
    let moveUpButtons = filterList.querySelectorAll('.move-up');
    let moveDownButtons = filterList.querySelectorAll('.move-down');
    let deleteButtons = filterList.querySelectorAll('.item-delete');
   
    function addListernersDelete(){
        deleteButtons = filterList.querySelectorAll('.item-delete');
        for (let i = 0; i < deleteButtons.length; i++){
            let button = deleteButtons[i];
            button.addEventListener("click", deleteItem);
        }
    };

    function addListernersMoveUp(){
        moveUpButtons = filterList.querySelectorAll('.move-up');
        for (let i = 0; i < moveUpButtons.length; i++){
            let button = moveUpButtons[i];
            button.addEventListener("click", moveUp);
        }
    }
    function addListernersMoveDown(){
        moveUpButtons = filterList.querySelectorAll('.move-down');
        for (let i = 0; i < moveUpButtons.length; i++){
            let button = moveUpButtons[i];
            button.addEventListener("click", moveDown);
        }
    }


    addListernersDelete();
    addListernersMoveUp();
    addListernersMoveDown();


    function deleteItem(event){
        event.preventDefault();
        event.target.closest('.filter-row').remove();   
        if(filterList.children.length <= 1){    
            noItems.classList.remove("false");
        }
    }

    function moveUp(event){
        event.preventDefault();
        let row = event.target.closest('.filter-row');
        let prev_row = event.target.closest('.filter-row').previousElementSibling;
        if (!prev_row.classList.contains("no-items")){
            row.after(prev_row);
        };
    }

    function moveDown(event){
        event.preventDefault();
        let row = event.target.closest('.filter-row');
        let next_row = event.target.closest('.filter-row').nextElementSibling;
        //console.log(next_row);
        if (next_row){
            next_row.after(row);
        }; 
    }
    selectElement.addEventListener("change", renderFilterOnSelect);

    function renderFilterOnSelect(){        
        let text = selectElement.options[selectElement.selectedIndex].text;
        let value = event.target.value;
        filterList.innerHTML += '<tr class="filter-row"><input type="hidden" name="kapital_post_filters[]" value="' + value + '"/><td><div class="filter-item">' + text + '</div></td><td><a href="" class="dashicons move-down dashicons-arrow-down-alt2"></a></td><td><a href="" class="dashicons move-up dashicons-arrow-up-alt2"></a></td><td><a href="" class="item-delete">Odstrániť filter</a></td></tr>';
        selectElement.selectedIndex = 0;
        noItems = filterList.querySelector(".no-items"); //no idea why I need to do this again
        console.log(noItems);
        console.log(filterList.children.length);
        if(filterList.children.length > 1){
            noItems.classList.add("false");
        }
        addListernersDelete();
        addListernersMoveUp();
        addListernersMoveDown();
    }
</script>
<?php } 


function add_darujme_submenu_page() {
	//create new submenu
	add_submenu_page('edit.php?post_type=inzercia', __('Nastavenie Darujme.sk', 'kapital'), __('Nastavenie Darujme.sk', 'kapital'), 'administrator', 'kapital_darujme', 'kapital_darujme_admin_page');
	//call register settings function
	add_action( 'admin_init', 'register_posts_filter_setting' );
}
add_action('admin_menu', 'add_darujme_submenu_page');

/*
 * Register the settings
 */
function kapital_register_darujme_settings(){
    //the third parameter is a function that will validate your input values
    register_setting('kapital_darujme_settings', 'kapital_darujme_settings', 'sanitize_darujme_options');
    add_settings_section(
		'kapital_darujme_settings',
		__( 'Nastavenia Darujme.sk', 'kapital' ), '',
		'kapital_darujme'
	);

    add_settings_field(
		'campaign_active', // As of WP 4.6 this value is used only internally.
		                        // Use $args' label_for to populate the id inside the callback.
		__( 'Aktivovať kampaň', 'kapital' ),
		'kapital_darujme_input_callback',
		'kapital_darujme',
		'kapital_darujme_settings',
		array(
            'type'              => 'checkbox',
            'name'              => 'campaign_active',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (empty(get_option('kapital_darujme_settings')['campaign_active'])),
            'checked'      => (!isset(get_option('kapital_darujme_settings')['campaign_active']))
                               ? 0 : get_option('kapital_darujme_settings')['campaign_active'],
			'label_for'         => 'campaign_active',
		)
	);
    add_settings_field(
		'campaign_id', // As of WP 4.6 this value is used only internally.
		                        // Use $args' label_for to populate the id inside the callback.
		__( 'ID kampane', 'kapital' ),
		'kapital_darujme_input_callback',
		'kapital_darujme',
		'kapital_darujme_settings',
		array(
            'type'              => 'text',
            'name'              => 'campaign_id',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['campaign_id']) ? '' : get_option('kapital_darujme_settings')['campaign_id']),
			'label_for'         => 'campaign_id',
            'description'       => __(' ID kampane nájdete na darujme.sk v záložke darovacie stránky pri vašej kampani po klinutí na "..." -> "Upraviť kampaň" -> "Rozšírené nastavenia" -> "ID kampane"', 'kapital')
		)
	);
    add_settings_field(
		'campaign_title', // As of WP 4.6 this value is used only internally.
		                        // Use $args' label_for to populate the id inside the callback.
		__( 'Nadpis kampane', 'kapital' ),
		'kapital_darujme_input_callback',
		'kapital_darujme',
		'kapital_darujme_settings',
		array(
            'type'              => 'text',
            'name'              => 'campaign_title',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['campaign_title']) ? '' : get_option('kapital_darujme_settings')['campaign_title']),
			'label_for'         => 'campaign_title',
            'description'       => __('Nadpis sa zobrazí v rozbalenej verzii bloku podpory.', 'kapital')
		)
	);
    add_settings_field(
		'donation_amount_onetime', // As of WP 4.6 this value is used only internally.
		                        // Use $args' label_for to populate the id inside the callback.
		__( 'Odporúčané ceny pre jednorazový príspevok', 'kapital' ),
		'kapital_darujme_input_callback',
		'kapital_darujme',
		'kapital_darujme_settings',
		array(
            'type'              => 'text',
            'name'              => 'donation_amount_onetime',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['donation_amount_onetime']) ? '' : get_option('kapital_darujme_settings')['donation_amount_onetime']),
			'label_for'         => 'donation_amount_onetime',
            'description'       => __('Číselná hodnota v eurách. Zadávajte iba nenulové celé čísla. Jednotlivé možnosti oddeľte čiarkou.', 'kapital')
		)
	);
    add_settings_field(
		'donation_amount_periodical', // As of WP 4.6 this value is used only internally.
		                        // Use $args' label_for to populate the id inside the callback.
		__( 'Odporúčané ceny pre pravidelné prispievanie', 'kapital' ),
		'kapital_darujme_input_callback',
		'kapital_darujme',
		'kapital_darujme_settings',
		array(
            'type'              => 'text',
            'name'              => 'donation_amount_periodical',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['donation_amount_periodical']) ? '' : get_option('kapital_darujme_settings')['donation_amount_periodical']),
			'label_for'         => 'donation_amount_periodical',
            'description'       => __('Číselná hodnota v eurách. Zadávajte iba nenulové celé čísla. Jednotlivé možnosti oddeľte čiarkou.', 'kapital')
		)
	);
    add_settings_field(
		'darujme_short_text', // As of WP 4.6 this value is used only internally.
		                        // Use $args' label_for to populate the id inside the callback.
		__( 'Krátky text kampane', 'kapital' ),
		'kapital_darujme_input_callback',
		'kapital_darujme',
		'kapital_darujme_settings',
		array(
            'type'              => 'textarea',
            'name'              => 'darujme_short_text',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['darujme_short_text']) ? '' : get_option('kapital_darujme_settings')['darujme_short_text']),
			'label_for'         => 'darujme_short_text',
            'description'       => __('Zobrazí sa v zbalenej verzii bloku podpory.', 'kapital')
		)
	);
    add_settings_field(
		'darujme_long_text', // As of WP 4.6 this value is used only internally.
		                        // Use $args' label_for to populate the id inside the callback.
		__( 'Dlhý text kampane', 'kapital' ),
		'kapital_darujme_input_callback',
		'kapital_darujme',
		'kapital_darujme_settings',
		array(
            'type'              => 'textarea',
            'name'              => 'darujme_long_text',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['darujme_long_text']) ? '' : get_option('kapital_darujme_settings')['darujme_long_text']),
			'label_for'         => 'darujme_long_text',
            'description'       => __('Zobrazí sa v rozbalenej verzii bloku podpory.', 'kapital')
		)
	);
    add_settings_field(
		'darujme_kapital_gdpr_url', // As of WP 4.6 this value is used only internally.
		                        // Use $args' label_for to populate the id inside the callback.
		__( 'Url Ochrany osobných údajov Kapitálu', 'kapital' ),
		'kapital_darujme_input_callback',
		'kapital_darujme',
		'kapital_darujme_settings',
		array(
            'type'              => 'url',
            'name'              => 'darujme_kapital_gdpr_url',
            'option_group'      => 'kapital_darujme_settings',
            'value'             => (!isset(get_option('kapital_darujme_settings')['darujme_kapital_gdpr_url']) ? '' : get_option('kapital_darujme_settings')['darujme_kapital_gdpr_url']),
			'label_for'         => 'darujme_kapital_gdpr_url',
		)
	);
}    
add_action('admin_init', 'kapital_register_darujme_settings');

// ------------------------------------------------------------------
// Callback function for our example setting
// ------------------------------------------------------------------
//
// creates a checkbox true/false option. Other types are surely possible
//

function kapital_darujme_input_callback($args)
{       
        //var_dump($args);
        // Could use ob_start.
        if ($args["type"] === "textarea"){
            $html  = '';
            $html .= '<textarea rows="8" cols="60" id="' . esc_attr( $args['name'] ) . '" 
            name="' . esc_attr( $args['option_group'] . '['.$args['name'].']') .'" 
            >' . $args["value"] . '</textarea>';          
            if (isset($args['description'])){
                $html .= '<p class="description">' . esc_html( $args['description'] ) .'</p>';
            }
            echo $html;            
        } elseif($args["type"] === "checkbox"){
            $checked = '';
            $options = get_option($args['option_group']);
            $value   = ( !isset( $options[$args['name']] ) ) 
                        ? null : $options[$args['name']];
            if($value) { $checked = ' checked="checked" '; }
            $html  = '';
            $html .= '<input id="' . esc_attr( $args['name'] ) . '" 
            name="' . esc_attr( $args['option_group'] . '['.$args['name'].']') .'" 
            type="checkbox"'  . $checked .  '"/>';
            if (isset($args['description'])){
                $html .= '<p class="description">' . esc_html( $args['description'] ) .'</p>';
            }
            echo $html;
        } else {
            $html  = '';
            $html .= '<input size="60" id="' . esc_attr( $args['name'] ) . '" 
            name="' . esc_attr( $args['option_group'] . '['.$args['name'].']') .'" 
            type="text" value="' . $args["value"] . '"/>';
            if (isset($args['description'])){
                $html .= '<p class="description">' . esc_html( $args['description'] ) .'</p>';
            }
            echo $html;
        }
}




/*
 * Register the settings
 */
/* add_action('admin_init', 'kapital_register_darujme_settings');
function kapital_register_darujme_settings(){
    //this will save the option in the wp_options table as 'wpse61431_settings'
    //the third parameter is a function that will validate your input values
    register_setting('kapital_darujme_settings', 'kapital_darujme_settings', 'kapital_darujme_settings_validate');
} */

function sanitize_darujme_options($args){
    //$args will contain the values posted in your settings form, you can validate them as no spaces allowed, no special chars allowed or validate emails etc.
    $is_donation_one_time_numeric = true;
    $is_donation_periodical_numeric = true;
    $donation_amount_periodical = $args['donation_amount_periodical'];
    $donation_amount_periodical = explode(',', $donation_amount_periodical);
    $donation_amount_periodical = array_map(function($item){
        $item = trim($item);
        return $item;
    }, $donation_amount_periodical);
    foreach($donation_amount_periodical as $item){
        if (!is_numeric($item) || $item === "0"){
            $is_donation_periodical_numeric = false;
        }
    }

    $donation_amount_onetime = $args['donation_amount_onetime'];
    $donation_amount_onetime = explode(',', $donation_amount_onetime);
    $donation_amount_onetime = array_map(function($item){
        $item = trim($item);
        return $item;
    }, $donation_amount_onetime);
    foreach($donation_amount_onetime as $item){
        if (!is_numeric($item) || $item === "0"){
            $is_donation_one_time_numeric = false;
        }
    }
    if(!isset($args['donation_amount_onetime']) || !$is_donation_one_time_numeric){
        //add a settings error because the email is invalid and make the form field blank, so that the user can enter again
        $args['donation_amount_onetime'] = '';
        add_settings_error('kapital_darujme_settings', 'kapital_darujme_settings_invalid_donation_amount_onetime', 'Pole "Odporúčané ceny pre jendorazový príspevok" môže obsahovať iba nenulové celé čísla oddelené čiarkou.  Prednastavená bude vždy druhá hodnota.', $type = 'error');   
    }
    if(!isset($args['donation_amount_periodical']) || !$is_donation_periodical_numeric){
        //add a settings error because the email is invalid and make the form field blank, so that the user can enter again
        $args['donation_amount_periodical'] = '';
        add_settings_error('kapital_darujme_settings', 'kapital_darujme_settings_invalid_donation_amount_onetime', 'Pole "Odporúčané ceny pre pravidelné prispievanie" môže obsahovať iba nenulové celé čísla oddelené čiarkou. Prednastavená bude vždy druhá hodnota.', $type = 'error');   
    }
    //make sure you return the args
    return $args;
}

//Display the validation errors and update messages
/*
 * Admin notices
 */
add_action('admin_notices', 'kapital_admin_notices');
function kapital_admin_notices(){
   settings_errors();
}

//The markup for your plugin settings page
function kapital_darujme_admin_page(){ ?>
    <div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post"><?php
        settings_fields( 'kapital_darujme_settings' );
        do_settings_sections( 'kapital_darujme' );
        submit_button( __('Uložiť nastavenia', 'kapital'));?>

        </form>
</div>
<script>

</script>
<?php } ?>
