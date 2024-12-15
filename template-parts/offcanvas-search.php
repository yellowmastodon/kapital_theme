<?php
$is_product_search = false;
$args;
if (isset($args["woocommerce"])){
  $is_product_search = $args["woocommerce"];
}
?>
<div class="offcanvas offcanvas-top p-3" tabindex="-1" id="offcanvasSearch" aria-labelledby="offcanvasTopLabel">
  <div class="offcanvas-header alignwide">
    <h2 class="mb-2" id="offcanvasTopLabel"><?=__("Hľadať", "kapital")?></h2>
    <button type="button" class="btn position-absolute btn-close" data-bs-dismiss="offcanvas" aria-label="<?=__("Zatvoriť dialóg vyhľadávania.", "kapital")?>">
        <svg class="icon-square"><use xlink:href="#icon-close"></svg>
    </button>
  </div>
  <div class="offcanvas-body ff-grotesk alignwide" tabindex="-1">
  <?php get_search_form(array('bg' => 'pink'));?>
  </div>
</div>