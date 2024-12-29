<?php

/**
 * The template for displaying search forms
 *
 * @package kapital
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$uid               = wp_unique_id('s-'); // The search form specific unique ID for the input.

$aria_label = '';
if (isset($args['aria_label']) && ! empty($args['aria_label'])) {
    $aria_label = 'aria-label="' . esc_attr($args['aria_label']) . '"';
}

$is_red_button = false;
if (isset($args['bg']) && ! empty($args['bg'])) {
    if ($args['bg'] === 'pink'){
        $is_red_button = true;
    }
}

global $is_woocommerce_site;

?>

<form role="search" class="search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>" <?php echo $aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above.?>>
    <?php if ($is_woocommerce_site) echo '<input type="hidden" name="post_type" value="product" />';?>
    <label class="visually-hidden" for="<?php echo $uid; ?>"><?php echo esc_html_x('Vyhľadať:', 'label', 'kapital'); ?></label>
    <div class="input-group mb-4">
            <input type="search" class="field search-field bg-secondary border-secondary form-control" id="<?php echo $uid; ?>" name="s" value="<?php the_search_query(); ?>" placeholder="<?php echo esc_attr_x('Vyhľadať &hellip;', 'placeholder', 'kapital'); ?>">
            <button aria-label="<?php echo esc_attr_x('Vyhľadať', 'submit button', 'kapital'); ?>" type="submit" class="submit search-submit btn ps-3 pe-4 btn-secondary"><svg class="icon-square"><use xlink:href="#icon-search"/></svg></button>
    </div>
</form>
<?php 
if ($is_woocommerce_site):
    printf(__('%sMomentálne vyhľadávate v produktoch.%sPre vyhľadávanie mimo e-shopu <a href="%s">prejdite sem</a>.%s'), '<p class="mb-2">', '</p><p class="mb-0">', get_home_url(get_main_site_id()) . '?s', '</p>');
else:
    printf(__('%sVaše vyhľadávanie momentálne nezahŕňa produkty.%sPre vyhľadávanie v e-shope <a href="%s">prejdite sem</a>.%s'), '<p class="mb-2">', '</p><p class="mb-0">', get_home_url(2) . '?s', '</p>');
endif;