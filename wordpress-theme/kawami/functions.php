<?php
/**
 * Kawami theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'KAWAMI_VERSION', '1.0.0' );

function kawami_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 112,
		'width'       => 112,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'automatic-feed-links' );

	// WooCommerce
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( array(
		'primary' => __( 'Menu principal', 'kawami' ),
		'footer'  => __( 'Menu du pied de page', 'kawami' ),
	) );
}
add_action( 'after_setup_theme', 'kawami_setup' );

function kawami_assets() {
	wp_enqueue_style(
		'kawami-fonts',
		'https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@400;500;700;900&family=Quicksand:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'kawami-style', get_stylesheet_uri(), array( 'kawami-fonts' ), KAWAMI_VERSION );
	wp_enqueue_script( 'kawami-header', get_template_directory_uri() . '/assets/js/kawami-header.js', array(), KAWAMI_VERSION, true );

	if ( is_product() ) {
		wp_enqueue_script( 'kawami-product', get_template_directory_uri() . '/assets/js/kawami-product.js', array(), KAWAMI_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'kawami_assets' );

/**
 * Availability badge (En stock / Précommande / Épuisé), mirrors the
 * Shopify build's rule: a "precommande" tag always wins, otherwise a
 * product that's purchasable with zero tracked stock (backorders
 * allowed) is a preorder, out of stock is "Épuisé", anything else is
 * "En stock".
 */
function kawami_availability_badge( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return '';
	}

	$state = 'instock';

	if ( has_term( 'precommande', 'product_tag', $product->get_id() ) ) {
		$state = 'preorder';
	} elseif ( ! $product->is_in_stock() ) {
		$state = 'soldout';
	} elseif ( $product->managing_stock() && $product->get_stock_quantity() !== null && $product->get_stock_quantity() <= 0 ) {
		$state = 'preorder';
	}

	switch ( $state ) {
		case 'preorder':
			$delay = get_theme_mod( 'kawami_preorder_delay_text', '2-3 semaines' );
			return '<div class="k-badge k-badge-preorder k-card__badge">Précommande · ' . esc_html( $delay ) . '</div>';
		case 'soldout':
			return '<div class="k-badge k-card__badge" style="background:var(--k-border);color:var(--k-text)">Épuisé</div>';
		default:
			return '<div class="k-badge k-badge-instock k-card__badge">En stock</div>';
	}
}

/**
 * Theme Customizer: logo/colors already come from core (custom-logo,
 * site icon); a couple of Kawami-specific text settings live here.
 */
function kawami_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'kawami_options', array(
		'title'    => __( 'Réglages Kawami', 'kawami' ),
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'kawami_preorder_delay_text', array(
		'default'           => '2-3 semaines',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kawami_preorder_delay_text', array(
		'label'   => __( 'Délai de précommande affiché', 'kawami' ),
		'section' => 'kawami_options',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kawami_free_shipping_threshold', array(
		'default'           => 120,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'kawami_free_shipping_threshold', array(
		'label'   => __( 'Seuil de livraison offerte (France, en €)', 'kawami' ),
		'section' => 'kawami_options',
		'type'    => 'number',
	) );

	$wp_customize->add_setting( 'kawami_social_instagram_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'kawami_social_instagram_url', array(
		'label'   => __( 'Lien Instagram', 'kawami' ),
		'section' => 'kawami_options',
		'type'    => 'url',
	) );

	$wp_customize->add_setting( 'kawami_social_tiktok_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'kawami_social_tiktok_url', array(
		'label'   => __( 'Lien TikTok', 'kawami' ),
		'section' => 'kawami_options',
		'type'    => 'url',
	) );

	// Page pickers for the header/footer nav - same idea as the Shopify
	// build's page-picker section settings, so the merchant just selects
	// existing WordPress pages instead of hardcoding slugs.
	$nav_pages = array(
		'kawami_page_accessoires' => __( 'Page « Accessoires »', 'kawami' ),
		'kawami_page_journaux'    => __( 'Page « Journaux »', 'kawami' ),
		'kawami_page_apropos'     => __( 'Page « Mon histoire »', 'kawami' ),
		'kawami_page_contact'     => __( 'Page « Contact »', 'kawami' ),
	);
	foreach ( $nav_pages as $setting_id => $label ) {
		$wp_customize->add_setting( $setting_id, array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( $setting_id, array(
			'label'   => $label,
			'section' => 'kawami_options',
			'type'    => 'dropdown-pages',
		) );
	}
}
add_action( 'customize_register', 'kawami_customize_register' );

/**
 * WooCommerce layout hooks: Kawami markup replaces most default wrappers
 * (see woocommerce/ template overrides), but we still remove a few
 * default hooks that don't fit the design and aren't overridden by a
 * template file.
 */
function kawami_woocommerce_setup() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
}
add_action( 'init', 'kawami_woocommerce_setup' );

/**
 * Returns the permalink for a nav page picked in the Customizer
 * (kawami_page_accessoires, kawami_page_journaux, kawami_page_apropos,
 * kawami_page_contact), or empty string if not set/published.
 */
function kawami_nav_page_url( $theme_mod_key ) {
	$page_id = absint( get_theme_mod( $theme_mod_key, 0 ) );
	if ( ! $page_id || get_post_status( $page_id ) !== 'publish' ) {
		return '';
	}
	return get_permalink( $page_id );
}

/**
 * Cart count bubble helper used in header.php.
 */
function kawami_cart_count() {
	if ( ! class_exists( 'WooCommerce' ) || is_admin() ) {
		return 0;
	}
	return WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
}
