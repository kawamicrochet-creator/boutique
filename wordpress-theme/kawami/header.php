<?php
/**
 * Kawami header: announcement marquee, sticky header with logo/nav/cart,
 * mobile hamburger drawer. Mirrors the Shopify build's kawami-header.liquid.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$shop_url        = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$accessoires_url = kawami_nav_page_url( 'kawami_page_accessoires' );
$journaux_url    = kawami_nav_page_url( 'kawami_page_journaux' );
$apropos_url     = kawami_nav_page_url( 'kawami_page_apropos' );
$contact_url     = kawami_nav_page_url( 'kawami_page_contact' );
$account_enabled = class_exists( 'WooCommerce' );
$cart_count      = kawami_cart_count();

$announcements = array(
	'🌍 Livraison soignée dans le monde entier 🌍',
	'🎁 Livraison gratuite en France dès ' . absint( get_theme_mod( 'kawami_free_shipping_threshold', 120 ) ) . ' € 🎁',
	'🧵 Précommandes : fabrication en ' . esc_html( get_theme_mod( 'kawami_preorder_delay_text', '2-3 semaines' ) ) . ' 🧵',
);
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="k-announce">
	<div class="k-announce__track-wrap">
		<div class="k-announce__track">
			<?php for ( $i = 0; $i < 2; $i++ ) : ?>
				<?php foreach ( $announcements as $text ) : ?>
					<span><?php echo esc_html( $text ); ?></span>
					<span class="k-announce__sep">·</span>
				<?php endforeach; ?>
			<?php endfor; ?>
		</div>
	</div>
</div>

<header class="k-header">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="k-header__logo">
		<?php if ( has_custom_logo() ) :
			$logo_id  = get_theme_mod( 'custom_logo' );
			$logo_src = wp_get_attachment_image_src( $logo_id, 'full' );
		?>
			<img src="<?php echo esc_url( $logo_src[0] ); ?>" width="56" height="56" alt="<?php bloginfo( 'name' ); ?>">
		<?php endif; ?>
		<span>
			<span class="k-header__wordmark">
				<span class="k-header__wordmark-name"><?php echo esc_html( strtoupper( get_bloginfo( 'name' ) ?: 'KAWAMI' ) ); ?></span>
				<span class="k-header__wordmark-mark">親友</span>
			</span>
			<span class="k-header__tagline">Peluches &amp; accessoires · fait main</span>
		</span>
	</a>

	<nav class="k-nav">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" <?php echo is_front_page() ? 'class="is-active"' : ''; ?>>Accueil</a>
		<div class="k-drop">
			<a href="<?php echo esc_url( $shop_url ); ?>">Boutique<span style="color: var(--k-text-muted)"> ▾</span></a>
			<div class="k-drop__menu">
				<a href="<?php echo esc_url( $shop_url ); ?>">Peluches</a>
				<?php if ( $accessoires_url ) : ?><a href="<?php echo esc_url( $accessoires_url ); ?>">Accessoires</a><?php endif; ?>
				<?php if ( $journaux_url ) : ?><a href="<?php echo esc_url( $journaux_url ); ?>">Journaux</a><?php endif; ?>
			</div>
		</div>
		<?php if ( $apropos_url ) : ?><a href="<?php echo esc_url( $apropos_url ); ?>">Mon histoire</a><?php endif; ?>
		<?php if ( $contact_url ) : ?><a href="<?php echo esc_url( $contact_url ); ?>">Contact</a><?php endif; ?>
		<?php if ( $account_enabled ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">Mon compte</a>
		<?php endif; ?>
	</nav>

	<div class="k-header__icons">
		<a href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" aria-label="Rechercher">
			<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" style="color: var(--k-text)"><circle cx="9" cy="9" r="6"></circle><path d="M13.5 13.5 L18 18"></path></svg>
		</a>
		<?php if ( $account_enabled ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="k-icon-link" aria-label="Mon compte">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="var(--k-text)" stroke-width="1.8"><circle cx="10" cy="6.5" r="3.5"></circle><path d="M3.5 18 Q10 12 16.5 18"></path></svg>
			</a>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="k-icon-link" aria-label="Panier">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="var(--k-text)" stroke-width="1.8"><path d="M4 6 H16 L15 17 H5 Z"></path><path d="M7 6 V5 a3 3 0 0 1 6 0 V6"></path></svg>
				<?php if ( $cart_count > 0 ) : ?><div class="k-cart-count"><?php echo (int) $cart_count; ?></div><?php endif; ?>
			</a>
		<?php endif; ?>
		<button type="button" class="k-mobile-toggle" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="kawami-mobile-nav">
			<svg width="22" height="22" viewBox="0 0 22 22" fill="none" stroke="var(--k-text)" stroke-width="1.8" stroke-linecap="round"><path d="M3 6 H19"></path><path d="M3 11 H19"></path><path d="M3 16 H19"></path></svg>
		</button>
	</div>
</header>

<nav id="kawami-mobile-nav" class="k-mobile-nav">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Accueil</a>
	<a href="<?php echo esc_url( $shop_url ); ?>">Boutique</a>
	<a href="<?php echo esc_url( $shop_url ); ?>" class="k-mobile-nav__sub">Peluches</a>
	<?php if ( $accessoires_url ) : ?><a href="<?php echo esc_url( $accessoires_url ); ?>" class="k-mobile-nav__sub">Accessoires</a><?php endif; ?>
	<?php if ( $journaux_url ) : ?><a href="<?php echo esc_url( $journaux_url ); ?>" class="k-mobile-nav__sub">Journaux</a><?php endif; ?>
	<?php if ( $apropos_url ) : ?><a href="<?php echo esc_url( $apropos_url ); ?>">Mon histoire</a><?php endif; ?>
	<?php if ( $contact_url ) : ?><a href="<?php echo esc_url( $contact_url ); ?>">Contact</a><?php endif; ?>
	<?php if ( $account_enabled ) : ?><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">Mon compte</a><?php endif; ?>
</nav>
