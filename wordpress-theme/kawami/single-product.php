<?php
/**
 * Kawami single product page. Keeps WooCommerce's native gallery,
 * variations and add-to-cart logic (AJAX, stock, price updates all work
 * out of the box) and restyles it via style.css + a couple of summary
 * hooks (see functions.php) for the availability badge, care-info list
 * and shipping/preorder/safety accordion.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

global $product;
$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
?>

<section class="k-container" style="padding: 36px 40px 60px">
	<div class="k-breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Accueil</a> <span style="opacity: .5">›</span>
		<a href="<?php echo esc_url( $shop_url ); ?>">Boutique</a> <span style="opacity: .5">›</span>
		<?php the_title(); ?>
	</div>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php wc_get_template_part( 'content', 'single-product' ); ?>
	<?php endwhile; ?>
</section>

<?php get_footer(); ?>
