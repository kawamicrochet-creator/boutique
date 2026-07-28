<?php
/**
 * Fallback template (required by WordPress for a theme to be valid).
 * Used for blog posts, search results, 404s - anything without a more
 * specific template (front-page.php, archive-product.php, single-
 * product.php, page-*.php).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<section class="k-container" style="padding: 44px 40px 60px">
	<?php if ( is_search() ) : ?>
		<h1 class="k-h1"><?php printf( esc_html__( 'Résultats pour « %s »', 'kawami' ), esc_html( get_search_query() ) ); ?></h1>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<div class="k-grid k-grid-3" style="margin-top: 20px">
			<?php while ( have_posts() ) : the_post(); ?>
				<a href="<?php the_permalink(); ?>" class="k-card">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="k-card__media"><?php the_post_thumbnail( 'medium' ); ?></div>
					<?php endif; ?>
					<div class="k-card__body">
						<div class="k-card__title"><?php the_title(); ?></div>
						<div class="k-card__subtitle"><?php echo esc_html( get_the_excerpt() ); ?></div>
					</div>
				</a>
			<?php endwhile; ?>
		</div>
		<div style="margin-top: 30px"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
		<h1 class="k-h1">Rien à afficher ici 🌸</h1>
		<p class="k-lead"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Retourner à l'accueil</a></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
