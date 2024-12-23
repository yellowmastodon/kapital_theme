<?php get_header();?>

<main role="main" <?php post_class('container main-content'); ?> id="main">
      <p class="alignnormal h4 text-uppercase text-red text-center">
         <?php printf(
            __("Stránka ktorú hľadáte sa nenašla. Prejdite na %sDomovskú stránku%s, alebo použite %svyhľadávanie%s.", "kapital"), 
            '<a class="text-red" href="' . get_home_url() . '">',
            '</a>',
            '<a class="text-red" href="' . get_site_url() . '/?s">',
            '</a>'
         )?>
      </p>
      <h1 data-text="404" class="text-center text-red">404</h1>
</main>

<?php get_footer();
