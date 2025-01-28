<?php
function kapital_customizer_settings($wp_customize)
{

    $wp_customize->add_section(
        'header_settings',
        array(
            'title'       => __('Nastavenia hlavičky a soc. sietí', 'kapital'),
            'capability'  => 'edit_theme_options',
            'description' => __('Linky v hlavičke a linky sociálnych sietí', 'kapital'),
        )

    );

    $wp_customize->add_setting(
        'eshop_url',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'eshop_url',
            array(
                'label'       => __('E-shop', 'kapital'),
                'description' => __('Link na e-shop stránku.'),
                'section'     => 'header_settings',
                'settings'    => 'eshop_url',
                'type'        => 'url',
            )
        )
    );

    $wp_customize->add_setting(
        'podpora',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'podpora',
            array(
                'label'       => __('Podpora', 'kapital'),
                'description' => __('Link na stránku podpory'),
                'section'     => 'header_settings',
                'settings'    => 'podpora',
                'type'        => 'url',
            )
        )
    );


    $wp_customize->add_setting(
        'english',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'english',
            array(
                'label'       => __('Anglické články', 'kapital'),
                'description' => __('Link na anglické články'),
                'section'     => 'header_settings',
                'settings'    => 'english',
                'type'        => 'url',
            )
        )
    );

    $wp_customize->add_setting(
        'facebook',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'facebook',
            array(
                'label'       => __('Facebook', 'kapital'),
                'description' => __('Link na facebookovú stránku'),
                'section'     => 'header_settings',
                'settings'    => 'facebook',
                'type'        => 'url',
            )
        )
    );
    $wp_customize->add_setting(
        'instagram',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'instagram',
            array(
                'label'       => __('Instagram', 'kapital'),
                'description' => __('Link na Instagram'),
                'section'     => 'header_settings',
                'settings'    => 'instagram',
                'type'        => 'url',
            )
        )
    );
    $wp_customize->add_setting(
        'youtube',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'youtube',
            array(
                'label'       => __('Youtube', 'kapital'),
                'description' => __('Link na YouTube'),
                'section'     => 'header_settings',
                'settings'    => 'youtube',
                'type'        => 'url',
            )
        )
    );
    $wp_customize->add_setting(
        'soundcloud',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'soundcloud',
            array(
                'label'       => __('Soundcloud', 'kapital'),
                'description' => __('Link na Soundcloud'),
                'section'     => 'header_settings',
                'settings'    => 'soundcloud',
                'type'        => 'url',
            )
        )
    );
    $wp_customize->add_setting(
        'twitter',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'twitter',
            array(
                'label'       => __('Twitter', 'kapital'),
                'description' => __('Link na Twitter'),
                'section'     => 'header_settings',
                'settings'    => 'twitter',
                'type'        => 'url',
            )
        )
    );

    $wp_customize->add_section(
        'footer_settings',
        array(
            'title'       => __('Nastavenia päty a newsletteru', 'kapital'),
            'capability'  => 'edit_theme_options',
        )

    );
    $wp_customize->add_setting(
        'middle_footer_column_text',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'middle_footer_column_text',
            array(
                'label'       => __('Text v strednom stĺpci päty', 'kapital'),
                'section'     => 'footer_settings',
                'settings'    => 'middle_footer_column_text',
                'type'        => 'textarea',
            )
        )
    );

    $wp_customize->add_setting(
        'bottom_footer_text',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'bottom_footer_text',
            array(
                'label'       => __('Text na konci päty.', 'kapital'),
                'section'     => 'footer_settings',
                'settings'    => 'bottom_footer_text',
                'type'        => 'textarea',
            )
        )
    );

    $wp_customize->add_setting(
        'ecomail_enabled',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'ecomail_enabled',
            array(
                'label'       => __('Povoliť prihlasovanie na newsletter ecomail.cz', 'kapital'),
                'section'     => 'footer_settings',
                'settings'    => 'ecomail_enabled',
                'type'        => 'checkbox',
            )
        )
    );

    $wp_customize->add_setting(
        'ecomail_post_url',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'ecomail_post_url',
            array(
                'label'       => __('POST url prihlasovania na newsletter ecomail.cz', 'kapital'),
                'section'     => 'footer_settings',
                'settings'    => 'ecomail_post_url',
                'type'        => 'url',
            )
        )
    );
    $wp_customize->add_setting(
        'ecomail_gdpr',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'ecomail_gdpr',
            array(
                'label'       => __('Text upozornenia o GDPR pri newsletteri', 'kapital'),
                'section'     => 'footer_settings',
                'settings'    => 'ecomail_gdpr',
                'type'        => 'textarea',
            )
        )
    );

}
add_action('customize_register', 'kapital_customizer_settings');