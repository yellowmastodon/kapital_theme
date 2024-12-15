<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kapital
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$search_string_empty = false;
global $is_woocommerce_site;
if (isset($args['search_string_empty'])) if ($args['search_string_empty']) $search_string_empty = true;
?>

<section class="no-results not-found alignwide ff-grotesk">

	<header class="page-header">

		<h1 class="page-title"><?php
        if ($search_string_empty){
            esc_html_e( 'Vyhľadávanie', 'kapital' );
        } else {
            esc_html_e( 'Žiadne výsledky', 'kapital' );
        }
        ?></h1>

	</header><!-- .page-header -->

	<div class="page-content">

		<?php
        if (!$search_string_empty){
            if ( is_search() ) :

                printf(
                    '<p>%s<p>',
                    __( 'Ospravedlňujeme sa, ale vášmu vyhľadávaniu nezodpovedajú žiadne výsledky. Skúste to znova s inými kľúčovými slovami.', 'kapital' )
                );
    
            else :
    
                printf(
                    '<p>%s<p>',
                    __( 'Zdá sa, že nemôžeme nájsť to, čo hľadáte. Možno pomôže hľadanie.', 'kapital' )
                );
    
            endif;
        }
        get_search_form();		
		?>
	</div><!-- .page-content -->

</section><!-- .no-results -->