<?php
/**
 * Generic page template - used for Cart, Checkout, Mon compte (WooCommerce's
 * own shortcode-driven pages) as well as any plain WordPress page that
 * doesn't have a more specific template. Cart/checkout logic itself stays
 * 100% native WooCommerce (AJAX updates, payment gateways, address
 * validation...) - only wrapped in the Kawami container + reskinned via
 * style.css so it isn't worth (or safe) to hand-recreate.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<section class="k-container" style="padding: 44px 40px 60px">
	<div class="k-breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Accueil</a> <span style="opacity: .5">›</span> <?php the_title(); ?></div>
	<?php while ( have_posts() ) : the_post(); ?>
		<h1 class="k-h1" style="margin-bottom: 20px"><?php the_title(); ?></h1>
		<div class="kawami-page-content">
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
</section>

<?php get_footer(); ?>
