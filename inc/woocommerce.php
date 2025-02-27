<?php
/**
 * WooCommerce Compatibility File
 */

/**
 * WooCommerce setup function.
 */
function taverna_woocommerce_setup() {
    // Declare WooCommerce support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'taverna_woocommerce_setup' );

/**
 * Remove default WooCommerce styles.
 */
function taverna_dequeue_woocommerce_styles( $enqueue_styles ) {
    // Remove the default WooCommerce styles
    unset( $enqueue_styles['woocommerce-general'] );
    unset( $enqueue_styles['woocommerce-layout'] );
    unset( $enqueue_styles['woocommerce-smallscreen'] );
    
    return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'taverna_dequeue_woocommerce_styles' );

/**
 * Add custom WooCommerce styles.
 */
function taverna_woocommerce_scripts() {
    wp_enqueue_style( 'taverna-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), TAVERNA_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'taverna_woocommerce_scripts' );

/**
 * Customize WooCommerce product columns.
 */
function taverna_woocommerce_loop_columns() {
    return 3;
}
add_filter( 'loop_shop_columns', 'taverna_woocommerce_loop_columns' );

/**
 * Customize related products count.
 */
function taverna_related_products_args( $args ) {
    $args['posts_per_page'] = 3;
    $args['columns'] = 3;
    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'taverna_related_products_args' );

/**
 * Customize WooCommerce product tabs.
 */
function taverna_woocommerce_product_tabs( $tabs ) {
    // Rename tabs
    if ( isset( $tabs['description'] ) ) {
        $tabs['description']['title'] = __( 'Detalhes do Produto', 'taverna' );
    }
    
    if ( isset( $tabs['reviews'] ) ) {
        $tabs['reviews']['title'] = __( 'Avaliações', 'taverna' );
    }
    
    if ( isset( $tabs['additional_information'] ) ) {
        $tabs['additional_information']['title'] = __( 'Informações Adicionais', 'taverna' );
    }
    
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'taverna_woocommerce_product_tabs' );

/**
 * Add custom product badge for 3D prints.
 */
function taverna_add_3d_print_badge() {
    global $product;
    
    // Check if product is in a specific category (replace 'impressao-3d' with your category slug)
    if ( has_term( 'impressao-3d', 'product_cat', $product->get_id() ) ) {
        echo '<span class="taverna-3d-badge">Impressão 3D</span>';
    }
}
add_action( 'woocommerce_before_shop_loop_item_title', 'taverna_add_3d_print_badge', 10 );
add_action( 'woocommerce_before_single_product_summary', 'taverna_add_3d_print_badge', 10 );

/**
 * Customize WooCommerce breadcrumbs.
 */
function taverna_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' &gt; ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x( 'Início', 'breadcrumb', 'taverna' ),
    );
}
add_filter( 'woocommerce_breadcrumb_defaults', 'taverna_woocommerce_breadcrumbs' );

/**
 * Customize cart fragments.
 */
function taverna_cart_link_fragment( $fragments ) {
    ob_start();
    taverna_cart_link();
    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'taverna_cart_link_fragment' );

/**
 * Cart Link.
 */
function taverna_cart_link() {
    ?>
    <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'Ver seu carrinho', 'taverna' ); ?>">
        <?php
        $item_count_text = sprintf(
            /* translators: number of items in the mini cart. */
            _n( '%d item', '%d itens', WC()->cart->get_cart_contents_count(), 'taverna' ),
            WC()->cart->get_cart_contents_count()
        );
        ?>
        <span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count">(<?php echo esc_html( $item_count_text ); ?>)</span>
    </a>
    <?php
}

/**
 * Display Header Cart.
 */
function taverna_header_cart() {
    if ( is_cart() ) {
        $class = 'current-menu-item';
    } else {
        $class = '';
    }
    ?>
    <ul id="site-header-cart" class="site-header-cart">
        <li class="<?php echo esc_attr( $class ); ?>">
            <?php taverna_cart_link(); ?>
        </li>
        <li>
            <?php
            $instance = array(
                'title' => '',
            );

            the_widget( 'WC_Widget_Cart', $instance );
            ?>
        </li>
    </ul>
    <?php
}
