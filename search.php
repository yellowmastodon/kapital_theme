<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package _s
 */

$is_search_string_empty = get_query_var("s") === "" ? true : false;

get_header();
global $is_woocommerce_site;
if ($is_woocommerce_site) {
    echo kapital_breadcrumbs([[__("E-shop", "kapital"), get_permalink(wc_get_page_id('shop'))], [__("Vyhľadávanie", "kapital"), "", true]], 'container');
} else {
    echo kapital_breadcrumbs([[__("Vyhľadávanie", "kapital"), "", true]], 'container');
}

?>
<main class="main container" role="main" id="main">
    <div class="alignwide">
        <?php if (!$is_search_string_empty && have_posts()) : ?>
            <header class="page-header alignwider">
                <h1 class="page-title">
                    <?php
                    /* translators: %s: search query. */
                    printf(esc_html__('Výsledky vyhľadávania pre: %s', 'kapital'), '<span>' . get_search_query() . '</span>');
                    ?>
                </h1>
            </header><!-- .page-header -->
            <?php get_search_form(); ?>
            <section class="alignwider mt-4">
        <?php
            /* Start the Loop */
            while (have_posts()) :
                the_post();

                /**
                 * Run the loop for the search to output the results.
                 * If you want to overload this in a child theme then include a file
                 * called content-search.php and that will be used instead.
                 */
                get_template_part('template-parts/content', 'search');

            endwhile;
          
            echo kapital_pagination(apply_filters( 'the_posts_pagination_args', array()));
            //the_posts_pagination();
        else:

            get_template_part('template-parts/content', 'none', array('search_string_empty' => $is_search_string_empty));

        endif;
        ?>
        </section>
    </div>

</main><!-- #main -->

<?php
get_footer();
