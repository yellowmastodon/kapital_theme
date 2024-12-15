<? 
function kapital_repeater_single_repeatable_meta_box_callback( $post ) {
$kapital_product_data_item = get_post_meta( $post->ID, '_kapital_product_data', true );
    $kapital_book_author = get_post_meta( $post->ID, '_kapital_book_author', true );
	wp_nonce_field( 'repeater_box', 'formType' );
	?>
	<table class="kapital-repeater-item-table">
        <p class="description"> <?=__('Dáta ktoré sa zobrazia v popise produktu. Pre výpočet poštovného je potrebné váhu zadať aj v záložke "Doprava".', "kapital")?> </p>
		<tbody>
            <tr class="kapital-repeater-sub-row"><td><strong><?=__("Autor knihy", "kapital")?><strong></td><td><input type="text" name="kapital_book_author" value="<?=$kapital_book_author?>" placeholder="<?=__("Meno autora. Ak sa nejedná o knihu, nechajte prázdne.", "kapital")?>"></td></tr>
            <tr><td><strong><?=__("Ďalšie vlastnosti", "kapital")?></strong></td></tr>
			<?php 
			if( $kapital_product_data_item ){
				foreach( $kapital_product_data_item as $item_key => $item_value ){
					$item1  = isset( $item_value["name"] ) ? $item_value["name"] : '';
					$item2  = isset( $item_value["value"] ) ? $item_value["value"] : '';
					?>
					<tr class="kapital-repeater-sub-row">				
						<td>
							<input type="text" name="<?php echo esc_attr( 'kapital_product_data['.$item_key.'][name]' ); ?>" value="<?php echo esc_attr( $item1 ); ?>" placeholder="<?=__("Vlastnosť (napr. rok vydania)", "kapital")?>">
						</td>
						<td>
							<input type="text" name="<?php echo esc_attr( 'kapital_product_data['.$item_key.'][value]' ); ?>" value="<?php echo esc_attr( $item2 ); ?>" placeholder="<?=__("Hodnota vlastnosti (napr. 2024)", "kapital")?>"/>
						</td>
						<td>
							<button class="kapital-repeater-remove-item button" type="button"><?php esc_html_e( 'Remove', 'kapital-repeater-codexcoach' ); ?></button>
						</td>
					</tr>
					<?php
				}
			} else {
				?>
				<tr class="kapital-repeater-sub-row">				
					<td>
						<input type="text" name="kapital_product_data[0][name]" placeholder="<?=__("Vlastnosť (napr. rok vydania)", "kapital")?>">
					</td>
					<td>
						<input type="text" name="kapital_product_data[0][value]" placeholder="<?=__("Hodnota vlastnosti (napr. 2024)", "kapital")?>"/>
					</td>
					<td>
						<button class="kapital-repeater-remove-item button" type="button"><?php esc_html_e( 'Remove', 'kapital' ); ?></button>
					</td>
				</tr>
				<?php
			}
			?>			
			<tr class="kapital-repeater-hide-tr">				
				<td>
					<input name="hide_kapital_product_data[rand_no][name]" type="text" placeholder="<?=__("Vlastnosť (napr. rok vydania)", "kapital")?>"/>	
				</td>
				<td>
					<input type="text" name="hide_kapital_product_data[rand_no][value]" placeholder="<?=__("Hodnota vlastnosti (napr. 2024)", "kapital")?>"/>
				</td>
				<td>
					<button class="kapital-repeater-remove-item button" type="button"><?php esc_html_e( 'Remove', 'kapital-repeater-codexcoach' ); ?></button>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4">
					<button class="kapital-repeater-add-item button button-secondary" type="button"><?php esc_html_e( 'Add another', 'kapital-repeater-codexcoach' ); ?></button>
				</td>
			</tr>
		</tfoot>
	</table>	
	<?php
}
add_action( 'save_post', 'kapital_repeater_single_repeatable_meta_box_save' );
function kapital_repeater_single_repeatable_meta_box_save( $post_id ) {

	if ( !isset( $_POST['formType'] ) && !wp_verify_nonce( $_POST['formType'], 'repeater_box' ) ){
		return;
	}

	if ( ! defined( 'DOING_AUTOSAVE' ) ) {
		define( 'DOING_AUTOSAVE', true );
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return false;
	}

	if ( isset( $_POST['kapital_product_data'] ) ){
		update_post_meta( $post_id, '_kapital_product_data', $_POST['kapital_product_data'] );
	} else {
		update_post_meta( $post_id, '_kapital_product_data', '' );
	}
    if ( isset( $_POST['kapital_book_author'] ) ){
        update_post_meta( $post_id, '_kapital_book_author', $_POST['kapital_book_author'] );

    } else{
		update_post_meta( $post_id, '_kapital_book_author', '' );
    }

}
add_action( 'admin_footer', 'kapital_repeater_single_repeatable_meta_box_footer' );
function kapital_repeater_single_repeatable_meta_box_footer(){
	?>
	<script type="text/javascript">		
		jQuery(document).ready(function($){
			jQuery(document).on('click', '.kapital-repeater-remove-item', function() {
				jQuery(this).parents('tr.kapital-repeater-sub-row').remove();
			}); 				
			jQuery(document).on('click', '.kapital-repeater-add-item', function() {
				var p_this = jQuery(this);    
				var row_no = parseFloat( jQuery('.kapital-repeater-item-table tr.kapital-repeater-sub-row').length );
				var row_html = jQuery('.kapital-repeater-item-table .kapital-repeater-hide-tr').html().replace(/rand_no/g, row_no).replace(/hide_kapital_product_data/g, 'kapital_product_data');
				jQuery('.kapital-repeater-item-table tbody').append('<tr class="kapital-repeater-sub-row">' + row_html + '</tr>');    
			});
		});
	</script>
	<?php
}
add_action( 'admin_head', 'kapital_repeater_single_repeatable_meta_box_header' );
function kapital_repeater_single_repeatable_meta_box_header(){
	?>
	<style type="text/css">
		.kapital-repeater-item-table, .kapital-repeater-item-table .kapital-repeater-sub-row input[type="text"]{
            width: 100%;
        }
        .kapital-repeater-item-table .kapital-repeater-sub-row td:first-child{max-width: 100px;}
		.kapital-repeater-hide-tr{ display: none; }
        #kapital-repeater-single-repeater-data{
            margin-top: 20px;
            margin-bottom: 20px;
        }
    
    </style>
	<?php
}