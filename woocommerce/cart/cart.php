<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>
<div class="woocommerce-cart-wrapper rounded p-0 p-md-4 ff-grotesk">
    <form class="woocommerce-cart-form container" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <?php do_action('woocommerce_before_cart_table'); ?>
        <div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <?php do_action('woocommerce_before_cart_contents'); ?>
            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                /**
                 * Filter the product name.
                 *
                 * @since 2.1.0
                 * @param string $product_name Name of the product in the cart.
                 * @param array $cart_item The product in the cart.
                 * @param string $cart_item_key Key for the product in the cart.
                 */
                $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
            ?>
                    <div class="bg-secondary p-3 p-md-4 rounded woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                        <div class="row justify-content-between gx-3 gy-3">

                            <div class="product-thumbnail col-4 col-sm-2">
                                <?php
                                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', kapital_responsive_image($_product->get_image_id(), "200px", false, 'rounded w-100'), $cart_item, $cart_item_key);

                                if (! $product_permalink) {
                                    echo $thumbnail; // PHPCS: XSS ok.
                                } else {
                                    printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                                }
                                ?>
                            </div>

                            <div class="product-name col-8 col-sm-10" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                <?php
                                if (! $product_permalink) {
                                    echo wp_kses_post($product_name . '&nbsp;');
                                } else {
                                    /**
                                     * This filter is documented above.
                                     *
                                     * @since 2.1.0
                                     */
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a class="text-decoration-none h4" href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                }

                                do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                // Meta data.
                                echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                // Backorder notification.
                                if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                }
                                ?>
                                <div class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                    <?php
                                    echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key) . __(' / ks', 'kapital'); // PHPCS: XSS ok.
                                    ?>
                                </div>
                            </div>
                            <div class="product-quantity col-auto" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                <div class="row gx-2">
                                    <?php if (!$_product->is_sold_individually()): ?>
                                        <div class="col-auto">
                                            <button aria-label="<?= sprintf(__('Znížiť počet produktu: %s o 1', 'kapital'), $product_name); ?>" class="kapital-woo-quantity-minus btn btn-white" type="button"><svg class="icon-square">
                                                    <use xlink:href="#icon-minus"></use>
                                                </svg></button>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-auto">
                                        <?php
                                        if ($_product->is_sold_individually()) {
                                            $min_quantity = 1;
                                            $max_quantity = 1;
                                        } else {
                                            $min_quantity = 0;
                                            $max_quantity = $_product->get_max_purchase_quantity();
                                        }

                                        $product_quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                                'input_value'  => $cart_item['quantity'],
                                                'max_value'    => $max_quantity,
                                                'min_value'    => $min_quantity,
                                                'product_name' => $product_name,
                                                'classes' => 'bg-black text-white'
                                            ),
                                            $_product,
                                            false
                                        );

                                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                                        ?>
                                    </div>
                                    <?php if (!$_product->is_sold_individually()): ?>

                                        <div class="col-auto">
                                            <button aria-label="<?= sprintf(__('Zvýšiť počet produktu: %s o 1', 'kapital'), $product_name); ?>" class="kapital-woo-quantity-plus btn btn-white" type="button"><svg class="icon-square">
                                                    <use xlink:href="#icon-plus"></use>
                                                </svg></button>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <div class="product-subtotal h3 fw-normal mb-0 d-inline-block" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                                    <?php
                                    echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                    ?>
                                </div>
                                <div class="product-remove ms-2 d-inline-block">
                                    <?php
                                    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                        'woocommerce_cart_item_remove_link',
                                        sprintf(
                                            '<a href="%s" class="remove btn btn-white" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg class="icon-square"><use xlink:href="#icon-close"></use></svg></a>',
                                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                                            /* translators: %s is the product name */
                                            esc_attr(sprintf(__('Odstrániť %s z košíka', 'kapital'), wp_strip_all_tags($product_name))),
                                            esc_attr($product_id),
                                            esc_attr($_product->get_sku())
                                        ),
                                        $cart_item_key
                                    );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>

                <?php if (wc_coupons_enabled()) { ?>
                    <div class="coupon">

                    <label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" /> <button type="submit" class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
                    <?php do_action('woocommerce_cart_coupon'); ?>
                    </div>

               <?php } ?>
            <div class="text-center">
                <button type="submit" class="button btn btn-primary<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>
            </div>
            <?php do_action('woocommerce_cart_actions'); ?>

            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

            <?php do_action('woocommerce_after_cart_contents'); ?>
        </div>
        <?php do_action('woocommerce_after_cart_table'); ?>
    </form>

    <?php do_action('woocommerce_before_cart_collaterals'); ?>

    <div class="cart-collaterals">
        <?php
        /**
         * Cart collaterals hook.
         *
         * @hooked woocommerce_cross_sell_display
         * @hooked woocommerce_cart_totals - 10
         */
        do_action('woocommerce_cart_collaterals');
        ?>
    </div>
</div>
<?php do_action('woocommerce_after_cart'); ?>