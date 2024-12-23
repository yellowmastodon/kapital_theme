<?php

defined( 'ABSPATH' ) || exit;


add_action( 'widgets_init', 'kapital_widgets_init' );

if ( ! function_exists( 'kapital_widgets_init' ) ) {
	/**
	 * Initializes themes widgets.
	 */
	function kapital_widgets_init() {
		register_sidebar(
			array(
				'name'          => __( 'Mailchimp v päte', 'kapital' ),
				'id'            => 'footer-mailchimp-signup',
				'description'   => __( 'Prihlasovanie k newslettru v päte', 'kapital' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s dynamic-classes">',
				'after_widget'  => '</div><!-- .footer-widget -->',
			)
		);
        register_sidebar(
			array(
				'name'          => __( 'Logá sponzorov v päte', 'kapital' ),
				'id'            => 'footer-logos',
				'description'   => __( 'Prihlasovanie k newslettru v päte', 'kapital' ),
                'before_widget' => '<div id="%1$s" class="footer-widget %2$s dynamic-classes">',
				'after_widget'  => '</div><!-- .footer-widget -->',
			)
		);
	}
} // End of function_exists( 'understrap_widgets_init' ).