<?php
/**
 * Kawami shop/category archive. Mirrors kawami-collection.liquid: custom
 * k-card grid (not WooCommerce's default loop templates) so the design
 * matches the rest of the site exactly, with the availability badge and
 * a "not found what you're after" callout at the bottom.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$queried_term = is_product_category() ? get_queried_object() : null;
$title        = $queried_term ? $queried_term->name : __( 'Boutique', 'kawami' );
$description  = $queried_term ? term_description( $queried_term ) : '';
$paged        = max( 1, get_query_var( 'paged' ) );

global $wp_query;
$products_count = (int) $wp_query->found_posts;
?>

<section class="k-container" style="padding: 44px 40px 60px">
	<div class="k-breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Accueil</a> <span style="opacity: .5">›</span> <?php echo esc_html( $title ); ?></div>
	<div style="display: flex; align-items: baseline; gap: 16px; flex-wrap: wrap">
		<h1 class="k-h1"><?php echo esc_html( $title ); ?> 🧸</h1>
		<span style="font: 500 14px var(--k-font-ui); color: var(--k-text-soft)"><?php echo (int) $products_count; ?> petites merveilles faites main</span>
	</div>
	<?php if ( $description ) : ?>
		<div class="k-lead" style="margin: 6px 0 24px; max-width: 560px"><?php echo wp_kses_post( $description ); ?></div>
	<?php else : ?>
		<p class="k-lead" style="margin: 6px 0 24px; max-width: 560px">« En stock » part sous 48 h ; « Précommande » est crocheté rien que pour toi sous <?php echo esc_html( get_theme_mod( 'kawami_preorder_delay_text', '2-3 semaines' ) ); ?>.</p>
	<?php endif; ?>

	<?php
	$categories = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true ) );
	if ( ! is_wp_error( $categories ) && $categories ) :
	?>
		<div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 26px">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="k-pill-choice<?php echo ! $queried_term ? ' is-active' : ''; ?>">Tout</a>
			<?php foreach ( $categories as $cat ) : ?>
				<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="k-pill-choice<?php echo ( $queried_term && $queried_term->term_id === $cat->term_id ) ? ' is-active' : ''; ?>"><?php echo esc_html( $cat->name ); ?></a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<div class="k-grid k-grid-4">
			<?php while ( have_posts() ) : the_post();
				global $product;
				if ( ! $product instanceof WC_Product ) {
					$product = wc_get_product( get_the_ID() );
				}
				if ( ! $product ) continue;
			?>
				<a href="<?php the_permalink(); ?>" class="k-card">
					<div class="k-card__media">
						<?php echo get_the_post_thumbnail( get_the_ID(), 'medium', array( 'loading' => 'lazy' ) ); ?>
						<?php echo kawami_availability_badge( $product ); ?>
					</div>
					<div class="k-card__body">
						<div class="k-card__title"><?php the_title(); ?></div>
						<div class="k-card__subtitle"><?php echo esc_html( wp_strip_all_tags( wc_get_product_category_list( get_the_ID() ) ) ); ?></div>
						<div class="k-card__price-row">
							<span class="k-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
							<span class="k-card__add">Ajouter +</span>
						</div>
					</div>
				</a>
			<?php endwhile; ?>
		</div>
		<div style="margin-top: 30px">
			<?php
			echo paginate_links( array( // phpcs:ignore
				'total'     => $wp_query->max_num_pages,
				'current'   => $paged,
				'prev_text' => '←',
				'next_text' => '→',
			) );
			?>
		</div>
	<?php else : ?>
		<p style="font: 600 14px var(--k-font-ui); color: var(--k-text-soft)">Aucun produit pour le moment.</p>
	<?php endif; ?>

	<div style="margin-top: 36px; background: var(--k-card); border: 1.5px solid var(--k-border); border-radius: 22px; padding: 26px 30px; display: flex; align-items: center; gap: 20px; flex-wrap: wrap">
		<div style="font-size: 26px">🎀</div>
		<div style="flex: 1; min-width: 260px">
			<div style="font: 700 16px var(--k-font-title); color: var(--k-text); margin-bottom: 4px">Tu ne trouves pas ton bonheur ?</div>
			<div style="font: 500 13px/1.55 var(--k-font-ui); color: var(--k-text-soft)">De nouvelles peluches arrivent régulièrement — suis-nous pour les voir naître maille par maille.</div>
		</div>
		<?php $contact_url = kawami_nav_page_url( 'kawami_page_contact' ); if ( $contact_url ) : ?>
			<a href="<?php echo esc_url( $contact_url ); ?>" class="k-btn k-btn-primary">Écris-moi</a>
		<?php endif; ?>
	</div>
</section>

<?php
wp_reset_postdata();
get_footer();
