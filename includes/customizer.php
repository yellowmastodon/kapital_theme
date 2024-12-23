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
            'title'       => __('Nastavenia päty', 'kapital'),
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
            'footer',
            array(
                'label'       => __('Text na konci päty.', 'kapital'),
                'section'     => 'footer_settings',
                'settings'    => 'bottom_footer_text',
                'type'        => 'textarea',
            )
        )
    );

}
add_action('customize_register', 'kapital_customizer_settings');