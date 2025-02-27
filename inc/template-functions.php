<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function taverna_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    // Add class if WooCommerce is active
    if ( class_exists( 'WooCommerce' ) ) {
        $classes[] = 'woocommerce-active';
        
        // Add shop class
        if ( is_shop() || is_product_category() || is_product_tag() ) {
            $classes[] = 'taverna-shop';
        }
        
        // Add single product class
        if ( is_product() ) {
            $classes[] = 'taverna-single-product';
        }
    }

    return $classes;
}
add_filter( 'body_class', 'taverna_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function taverna_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'taverna_pingback_header' );

/**
 * Change excerpt length
 */
function taverna_custom_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'taverna_custom_excerpt_length', 999 );

/**
 * Change excerpt more text
 */
function taverna_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'taverna_excerpt_more' );

/**
 * Get custom colors from Customizer
 */
function taverna_get_custom_colors() {
    $colors = array(
        'primary'   => get_theme_mod( 'taverna_primary_color', '#7D5B3A' ),
        'secondary' => get_theme_mod( 'taverna_secondary_color', '#5A4430' ),
        'accent'    => get_theme_mod( 'taverna_accent_color', '#D4AF37' ),
    );
    
    return $colors;
}

/**
 * Add custom colors to head
 */
function taverna_custom_colors_css() {
    $colors = taverna_get_custom_colors();
    ?>
    <style type="text/css">
        :root {
            --taverna-primary: <?php echo esc_attr( $colors['primary'] ); ?>;
            --taverna-secondary: <?php echo esc_attr( $colors['secondary'] ); ?>;
            --taverna-accent: <?php echo esc_attr( $colors['accent'] ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'taverna_custom_colors_css' );
