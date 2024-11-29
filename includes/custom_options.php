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
<?php } ?>