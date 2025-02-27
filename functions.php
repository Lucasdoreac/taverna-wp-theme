<?php
/**
 * Taverna da Impressão functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Define constants
define( 'TAVERNA_THEME_VERSION', '1.0.0' );
define( 'TAVERNA_THEME_DIR', get_template_directory() );
define( 'TAVERNA_THEME_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function taverna_setup() {
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages
	add_theme_support( 'post-thumbnails' );

	// Add theme support for selective refresh for widgets
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Add support for WooCommerce
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	
	// Register navigation menus
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Menu Principal', 'taverna' ),
			'footer'  => esc_html__( 'Menu Rodapé', 'taverna' ),
		)
	);
}
add_action( 'after_setup_theme', 'taverna_setup' );

/**
 * Enqueue scripts and styles
 */
function taverna_scripts() {
	// Enqueue Google Fonts
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap', array(), null );
	
	// Enqueue main stylesheet
	wp_enqueue_style( 'taverna-style', get_stylesheet_uri(), array(), TAVERNA_THEME_VERSION );
	
	// Enqueue custom JS
	wp_enqueue_script( 'taverna-navigation', TAVERNA_THEME_URI . '/assets/js/navigation.js', array(), TAVERNA_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'taverna_scripts' );

/**
 * Register widget area
 */
function taverna_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'taverna' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Adicione widgets aqui.', 'taverna' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Rodapé', 'taverna' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Adicione widgets ao rodapé aqui.', 'taverna' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'taverna_widgets_init' );

/**
 * Customize WooCommerce
 */
function taverna_woocommerce_setup() {
	// Remove default WooCommerce styles
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	
	// Remove product title from single product
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	
	// Add product title with custom markup
	add_action( 'woocommerce_single_product_summary', 'taverna_woocommerce_template_single_title', 5 );
}
add_action( 'after_setup_theme', 'taverna_woocommerce_setup' );

/**
 * Custom title for single product
 */
function taverna_woocommerce_template_single_title() {
	the_title( '<h1 class="product_title entry-title taverna-product-title">', '</h1>' );
}

/**
 * Include required files
 */
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';

// Check if WooCommerce is active
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
