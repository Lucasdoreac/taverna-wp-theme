<?php
/**
 * Taverna da Impressão Theme Customizer
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function taverna_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'taverna_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'taverna_customize_partial_blogdescription',
            )
        );
    }

    // Taverna Customizer Settings
    $wp_customize->add_section(
        'taverna_colors',
        array(
            'title'       => __( 'Cores da Taverna', 'taverna' ),
            'priority'    => 30,
            'description' => __( 'Personalize as cores do tema Taverna da Impressão', 'taverna' ),
        )
    );

    // Primary Color
    $wp_customize->add_setting(
        'taverna_primary_color',
        array(
            'default'           => '#7D5B3A',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'taverna_primary_color',
            array(
                'label'    => __( 'Cor Principal', 'taverna' ),
                'section'  => 'taverna_colors',
                'settings' => 'taverna_primary_color',
            )
        )
    );

    // Secondary Color
    $wp_customize->add_setting(
        'taverna_secondary_color',
        array(
            'default'           => '#5A4430',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'taverna_secondary_color',
            array(
                'label'    => __( 'Cor Secundária', 'taverna' ),
                'section'  => 'taverna_colors',
                'settings' => 'taverna_secondary_color',
            )
        )
    );

    // Accent Color
    $wp_customize->add_setting(
        'taverna_accent_color',
        array(
            'default'           => '#D4AF37',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'taverna_accent_color',
            array(
                'label'    => __( 'Cor de Destaque', 'taverna' ),
                'section'  => 'taverna_colors',
                'settings' => 'taverna_accent_color',
            )
        )
    );
}
add_action( 'customize_register', 'taverna_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function taverna_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function taverna_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function taverna_customize_preview_js() {
    wp_enqueue_script( 'taverna-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), TAVERNA_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'taverna_customize_preview_js' );
