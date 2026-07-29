<?php
/**
 * Kawami homepage. Mirrors theme/templates/index.json from the Shopify
 * build: hero, mes univers, featured products, custom order, atelier
 * couture teaser, story teaser, instagram, newsletter.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<section class="k-container k-split" style="padding: 64px 40px 40px; display: grid; grid-template-columns: 1.05fr .95fr; gap: 48px; align-items: center; position: relative; overflow: visible">
	<div class="k-anim-glow" style="position: absolute; left: -120px; top: -40px; width: 520px; height: 520px; border-radius: 50%; background: radial-gradient(circle, var(--k-pink-soft) 0%, rgba(248,205,216,0) 70%); filter: blur(10px); z-index: 0; pointer-events: none"></div>
	<div class="k-anim-glow" style="position: absolute; right: -80px; bottom: -80px; width: 460px; height: 460px; border-radius: 50%; background: radial-gradient(circle, var(--k-lavender) 0%, rgba(213,195,232,0) 70%); filter: blur(10px); z-index: 0; pointer-events: none; animation-delay: 1.5s"></div>

	<div style="position: relative; z-index: 1">
		<?php $eyebrow = kawami_field( 'kawami_hero_eyebrow' ); if ( $eyebrow ) : ?>
			<div class="k-eyebrow k-anim-rise" style="margin-bottom: 20px"><?php echo esc_html( $eyebrow ); ?></div>
		<?php endif; ?>
		<h1 class="k-anim-rise" style="font: 900 62px/1.1 var(--k-font-title); color: var(--k-text); margin: 0 0 18px; text-wrap: pretty; animation-delay: .15s"><?php echo esc_html( kawami_field( 'kawami_hero_title' ) ); ?></h1>
		<p class="k-lead k-anim-rise" style="font-size: 17px; margin: 0 0 28px; max-width: 460px; animation-delay: .28s"><?php echo esc_html( kawami_field( 'kawami_hero_subtitle' ) ); ?></p>
		<div class="k-anim-rise" style="display: flex; gap: 14px; align-items: center; flex-wrap: wrap; animation-delay: .4s">
			<?php $primary_text = kawami_field( 'kawami_hero_primary_cta_text' ); if ( $primary_text ) : ?>
				<a href="<?php echo esc_url( kawami_field( 'kawami_hero_primary_cta_url' ) ?: ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#' ) ); ?>" class="k-btn k-btn-primary"><?php echo esc_html( $primary_text ); ?></a>
			<?php endif; ?>
			<?php $secondary_text = kawami_field( 'kawami_hero_secondary_cta_text' ); if ( $secondary_text ) : ?>
				<a href="<?php echo esc_url( kawami_field( 'kawami_hero_secondary_cta_url' ) ?: '#' ); ?>" class="k-btn k-btn-secondary"><?php echo esc_html( $secondary_text ); ?></a>
			<?php endif; ?>
		</div>
		<div class="k-anim-rise" style="display: flex; gap: 26px; margin-top: 34px; flex-wrap: wrap; animation-delay: .52s">
			<?php
			// Trust badges: fixed set of 3 (not exposed in the Customizer to keep
			// its size manageable) - edit the array below to change text/colors.
			$trust_badges = array(
				array( 'icon' => '🎀', 'bg' => '#f8cdd8', 'text' => '100% fait main<br>pièces uniques' ),
				array( 'icon' => '🌿', 'bg' => '#d5c3e8', 'text' => 'Laine certifiée<br>Oeko-Tex' ),
				array( 'icon' => '💌', 'bg' => '#bfe3d2', 'text' => 'Précommande<br>' . esc_html( get_theme_mod( 'kawami_preorder_delay_text', '2-3 semaines' ) ) ),
			);
			foreach ( $trust_badges as $badge ) : ?>
				<div style="display: flex; align-items: center; gap: 9px">
					<div style="width: 34px; height: 34px; border-radius: 50%; background: <?php echo esc_attr( $badge['bg'] ); ?>; display: flex; align-items: center; justify-content: center; font-size: 15px"><?php echo esc_html( $badge['icon'] ); ?></div>
					<div style="font: 600 12px/1.35 var(--k-font-ui); color: var(--k-text-soft)"><?php echo wp_kses_post( $badge['text'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="k-hero-visual" style="position: relative; height: 480px; z-index: 1; overflow: visible">
		<?php $image_1 = kawami_field_image( 'kawami_hero_image_1' ); if ( $image_1 ) : ?>
			<div class="k-hero-visual__main" style="position: absolute; right: 22px; top: 0; width: 330px; height: 330px; border-radius: 46% 54% 52% 48%/50% 46% 54% 50%; overflow: hidden; border: 8px solid #fff; box-shadow: 0 14px 40px rgba(92,67,81,.16)">
				<img src="<?php echo esc_url( $image_1 ); ?>" style="width: 100%; height: 100%; object-fit: cover" alt="">
			</div>
			<?php $tag_text = kawami_field( 'kawami_hero_price_tag_text' ); if ( $tag_text ) : ?>
				<div class="k-hero-visual__tag" style="position: absolute; z-index: 3; background: #fff; border-radius: 16px; padding: 12px 18px; box-shadow: 0 8px 22px rgba(92,67,81,.14); font: 700 13px var(--k-font-ui); color: var(--k-text); transform: rotate(3deg); right: -18px; top: 120px; white-space: nowrap">
					<?php echo esc_html( $tag_text ); ?><br><span style="font: 600 12px var(--k-font-ui); color: var(--k-primary)"><?php echo esc_html( kawami_field( 'kawami_hero_price_tag_price' ) ); ?></span>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php $image_2 = kawami_field_image( 'kawami_hero_image_2' ); if ( $image_2 ) : ?>
			<div class="k-hero-visual__accent" style="position: absolute; left: -10px; bottom: -6px; width: 200px; height: 200px; border-radius: 50%; overflow: hidden; border: 8px solid #fff; box-shadow: 0 12px 32px rgba(92,67,81,.18)">
				<img src="<?php echo esc_url( $image_2 ); ?>" style="width: 100%; height: 100%; object-fit: cover" alt="">
			</div>
		<?php endif; ?>
		<div class="k-anim-float" style="position: absolute; left: 0; top: 46px; font-size: 26px">🌸</div>
		<div class="k-anim-float" style="position: absolute; right: -6px; top: 210px; font-size: 20px; animation-delay: .8s">🌸</div>
		<div class="k-anim-twinkle" style="position: absolute; right: 66px; top: -14px; font-size: 22px">✨</div>
		<div class="k-anim-twinkle" style="position: absolute; left: 44px; bottom: -6px; font-size: 18px; animation-delay: 1s">✨</div>
	</div>
</section>

<?php
// ---------- Mes univers: product categories (each category's own image,
// set in Produits > Catégories, becomes the tile photo) ----------
$univers_terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'number' => 5, 'exclude' => array( get_option( 'default_product_cat' ) ) ) );
if ( ! is_wp_error( $univers_terms ) && $univers_terms ) :
?>
<section class="k-container" style="padding: 34px 40px 10px">
	<div style="display: flex; align-items: baseline; gap: 14px; margin-bottom: 22px">
		<h2 class="k-h2"><?php echo esc_html( kawami_field( 'kawami_univers_title' ) ); ?></h2>
		<span style="font: 500 13px var(--k-font-ui); color: var(--k-text-muted)"><?php echo esc_html( kawami_field( 'kawami_univers_subtitle' ) ); ?></span>
	</div>
	<div class="k-grid k-grid-5">
		<?php foreach ( $univers_terms as $term ) :
			$thumb_id  = get_term_meta( $term->term_id, 'thumbnail_id', true );
			$image_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium' ) : '';
		?>
			<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" style="display: flex; flex-direction: column; align-items: center; gap: 10px; background: var(--k-card); border-radius: 20px; padding: 18px 12px 16px; border: 1.5px solid var(--k-border); text-align: center">
				<?php if ( $image_url ) : ?>
					<img src="<?php echo esc_url( $image_url ); ?>" style="width: 84px; height: 84px; border-radius: 50%; object-fit: cover; border: 3px solid var(--k-pink-soft)" alt="<?php echo esc_attr( $term->name ); ?>">
				<?php endif; ?>
				<div style="font: 700 14px var(--k-font-title); color: var(--k-text)"><?php echo esc_html( $term->name ); ?></div>
				<div style="font: 500 11px var(--k-font-ui); color: var(--k-text-muted)"><?php echo esc_html( $term->count ); ?> article<?php echo $term->count > 1 ? 's' : ''; ?></div>
			</a>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<section class="k-container" style="padding: 48px 40px 26px">
	<div style="display: flex; align-items: baseline; gap: 14px; margin-bottom: 6px">
		<h2 class="k-h2"><?php echo esc_html( kawami_field( 'kawami_featured_title' ) ); ?></h2>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" style="margin-left: auto; font: 700 13px var(--k-font-ui); color: #c76b88">Tout voir →</a>
	</div>
	<p class="k-lead" style="font-size: 13.5px; margin: 0 0 22px"><?php echo esc_html( kawami_field( 'kawami_featured_subtitle' ) ); ?></p>
	<div class="k-grid k-grid-4">
		<?php
		$featured_query = new WP_Query( array(
			'post_type'      => 'product',
			'posts_per_page' => 4,
			'orderby'        => 'date',
			'order'          => 'DESC',
		) );
		if ( $featured_query->have_posts() ) :
			while ( $featured_query->have_posts() ) : $featured_query->the_post();
				global $product;
				if ( ! $product instanceof WC_Product ) {
					$product = wc_get_product( get_the_ID() );
				}
		?>
			<a href="<?php the_permalink(); ?>" class="k-card">
				<div class="k-card__media">
					<?php echo get_the_post_thumbnail( get_the_ID(), 'medium', array( 'loading' => 'lazy' ) ); ?>
					<?php echo kawami_availability_badge( $product ); ?>
				</div>
				<div class="k-card__body">
					<div class="k-card__title"><?php the_title(); ?></div>
					<div class="k-card__subtitle"><?php echo esc_html( wc_get_product_category_list( get_the_ID() ) ? wp_strip_all_tags( wc_get_product_category_list( get_the_ID() ) ) : '' ); ?></div>
					<div class="k-card__price-row">
						<span class="k-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
						<span class="k-card__add">Voir +</span>
					</div>
				</div>
			</a>
		<?php endwhile; wp_reset_postdata();
		else : ?>
			<p style="font: 500 13px var(--k-font-ui); color: var(--k-text-muted)">Ajoute des produits dans WooCommerce pour les voir apparaître ici.</p>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<section class="k-container" id="commande-perso" style="padding: 56px 40px">
	<div class="k-split" style="background: var(--k-card); border: 1.5px solid var(--k-border); border-radius: 28px; padding: 38px 42px; display: grid; grid-template-columns: 1fr 1fr; gap: 44px; align-items: center">
		<div>
			<div class="k-eyebrow" style="margin-bottom: 16px"><?php echo esc_html( kawami_field( 'kawami_co_eyebrow' ) ); ?></div>
			<h2 style="font: 900 30px/1.22 var(--k-font-title); color: var(--k-text); margin: 0 0 14px; text-wrap: pretty"><?php echo esc_html( kawami_field( 'kawami_co_title' ) ); ?></h2>
			<p class="k-lead" style="margin: 0 0 16px"><?php echo esc_html( kawami_field( 'kawami_co_text' ) ); ?></p>
			<?php $co_note = kawami_field( 'kawami_co_note' ); if ( $co_note ) : ?>
				<div style="background: #fff7e8; border: 1.5px solid #f0dcb8; border-radius: 16px; padding: 14px 18px; font: 600 12.5px/1.6 var(--k-font-ui); color: var(--k-beige-darker)"><?php echo esc_html( $co_note ); ?></div>
			<?php endif; ?>
		</div>
		<div style="background: var(--k-bg); border-radius: 20px; padding: 28px 30px">
			<div style="font: 700 15px var(--k-font-title); color: var(--k-text); margin-bottom: 14px">Comment ça marche</div>
			<div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 20px">
				<?php
				$step_colors = array( '#f8cdd8', '#d5c3e8', '#bfe3d2' );
				$steps = array(
					"Choisis un modèle existant et les couleurs qui te font envie",
					"Écris-moi pour vérifier si c'est faisable selon le carnet de commandes du moment",
					"Je te confirme le délai et on lance ta pièce unique 🌸",
				);
				foreach ( $steps as $i => $step_text ) : ?>
					<div style="display: flex; gap: 12px">
						<div style="width: 26px; height: 26px; flex: none; border-radius: 50%; background: <?php echo esc_attr( $step_colors[ $i % count( $step_colors ) ] ); ?>; color: var(--k-text); font: 700 12px var(--k-font-ui); display: flex; align-items: center; justify-content: center"><?php echo (int) ( $i + 1 ); ?></div>
						<div style="font: 500 13px/1.5 var(--k-font-ui); color: var(--k-text-soft)"><?php echo esc_html( $step_text ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $co_cta_text = kawami_field( 'kawami_co_cta_text' ); if ( $co_cta_text ) : ?>
				<a href="<?php echo esc_url( kawami_field( 'kawami_co_cta_url' ) ?: '#' ); ?>" class="k-btn k-btn-primary" style="display: block; width: 100%"><?php echo esc_html( $co_cta_text ); ?></a>
			<?php endif; ?>
			<div style="font: 500 11px/1.5 var(--k-font-ui); color: var(--k-text-muted); text-align: center; margin-top: 10px">La faisabilité dépend du volume de commandes en cours 💌</div>
		</div>
	</div>
</section>

<section style="background: var(--k-beige); border-top: 1px solid var(--k-beige-border); border-bottom: 1px solid var(--k-beige-border); margin-top: 30px">
	<div class="k-container k-split" style="padding: 56px 40px; display: grid; grid-template-columns: 1.25fr .75fr; gap: 52px; align-items: center">
		<div style="position: relative">
			<div class="k-photo-frame k-rotate-n2" style="min-height: 260px">
				<?php $ac_image = kawami_field_image( 'kawami_ac_image' ); if ( $ac_image ) : ?>
					<img src="<?php echo esc_url( $ac_image ); ?>" style="width: 100%; height: 100%; object-fit: cover" alt="">
				<?php endif; ?>
			</div>
			<?php $ac_tag = kawami_field( 'kawami_ac_tag_text' ); if ( $ac_tag ) : ?>
				<div style="position: absolute; right: -10px; bottom: -12px; background: var(--k-beige); border: 1.5px solid var(--k-beige-border); border-radius: 999px; padding: 10px 18px; transform: rotate(2deg); box-shadow: 0 6px 16px rgba(92,67,81,.12)" class="k-italic-accent">
					<span style="color: var(--k-beige-darker); font-size: 15px"><?php echo esc_html( $ac_tag ); ?></span>
				</div>
			<?php endif; ?>
		</div>
		<div>
			<div class="k-italic-accent" style="color: #b98a63; letter-spacing: .08em; margin-bottom: 10px; font-size: 15px"><?php echo esc_html( kawami_field( 'kawami_ac_eyebrow' ) ); ?></div>
			<h2 style="font: 900 34px/1.2 var(--k-font-title); color: var(--k-text); margin: 0 0 16px; text-wrap: pretty"><?php echo esc_html( kawami_field( 'kawami_ac_title' ) ); ?> <span class="k-italic-accent" style="color: var(--k-beige-deep); font-size: 38px"><?php echo esc_html( kawami_field( 'kawami_ac_title_accent' ) ); ?></span></h2>
			<p class="k-lead" style="font-size: 15px; margin: 0 0 22px; max-width: 440px"><?php echo esc_html( kawami_field( 'kawami_ac_text' ) ); ?></p>
			<?php $ac_cta_text = kawami_field( 'kawami_ac_cta_text' ); if ( $ac_cta_text ) : ?>
				<a href="<?php echo esc_url( kawami_field( 'kawami_ac_cta_url' ) ?: '#' ); ?>" style="display: inline-block; font: 700 14px var(--k-font-ui); color: var(--k-beige-darker); border: 2px solid #d9bd9c; padding: 12px 24px; border-radius: 999px"><?php echo esc_html( $ac_cta_text ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="k-container k-split" style="padding: 60px 40px; display: grid; grid-template-columns: .9fr 1.1fr; gap: 52px; align-items: center">
	<div style="position: relative">
		<div class="k-photo-frame k-rotate-n2">
			<?php $st_image = kawami_field_image( 'kawami_st_image' ); if ( $st_image ) : ?>
				<img src="<?php echo esc_url( $st_image ); ?>" style="width: 100%; aspect-ratio: 1; object-fit: cover" alt="">
			<?php endif; ?>
		</div>
		<?php $st_tag = kawami_field( 'kawami_st_tag_text' ); if ( $st_tag ) : ?>
			<div style="position: absolute; right: -10px; bottom: -14px; background: var(--k-pink-soft); border-radius: 999px; padding: 10px 18px; font: 700 12.5px var(--k-font-ui); color: var(--k-text); transform: rotate(3deg); box-shadow: 0 6px 16px rgba(92,67,81,.15)"><?php echo esc_html( $st_tag ); ?></div>
		<?php endif; ?>
	</div>
	<div>
		<div style="font: 700 12px var(--k-font-ui); letter-spacing: .22em; color: var(--k-text-muted); text-transform: uppercase; margin-bottom: 12px"><?php echo esc_html( kawami_field( 'kawami_st_eyebrow' ) ); ?></div>
		<h2 style="font: 900 32px/1.25 var(--k-font-title); color: var(--k-text); margin: 0 0 16px; text-wrap: pretty"><?php echo esc_html( kawami_field( 'kawami_st_title' ) ); ?></h2>
		<p class="k-lead" style="font-size: 15px; margin: 0 0 14px"><?php echo esc_html( kawami_field( 'kawami_st_text' ) ); ?></p>
		<?php $st_link_text = kawami_field( 'kawami_st_link_text' ); if ( $st_link_text ) : ?>
			<a href="<?php echo esc_url( kawami_field( 'kawami_st_link_url' ) ?: '#' ); ?>" style="font: 700 14px var(--k-font-ui); color: #c76b88"><?php echo esc_html( $st_link_text ); ?> →</a>
		<?php endif; ?>
	</div>
</section>

<section style="background: #fff; border-top: 1px solid var(--k-border)">
	<div class="k-container" style="padding: 52px 40px">
		<div style="display: flex; align-items: baseline; gap: 16px; margin-bottom: 22px">
			<h2 style="font: 900 24px var(--k-font-title); color: var(--k-text); margin: 0"><?php echo esc_html( kawami_field( 'kawami_ig_title' ) ); ?></h2>
			<div style="margin-left: auto; display: flex; gap: 16px; font: 700 13px var(--k-font-ui)">
				<?php $ig_url = get_theme_mod( 'kawami_social_instagram_url', '' ); if ( $ig_url ) : ?><a href="<?php echo esc_url( $ig_url ); ?>" target="_blank" rel="noopener">Instagram ↗</a><?php endif; ?>
				<?php $tt_url = get_theme_mod( 'kawami_social_tiktok_url', '' ); if ( $tt_url ) : ?><a href="<?php echo esc_url( $tt_url ); ?>" target="_blank" rel="noopener">TikTok ↗</a><?php endif; ?>
			</div>
		</div>
		<div class="k-insta-embed">
			<?php echo do_shortcode( '[trustindex-feed-instagram]' ); ?>
		</div>
	</div>
</section>

<section style="position: relative; background: var(--k-pink-soft)<?php echo kawami_field_image( 'kawami_nl_bg_image' ) ? '; overflow: hidden' : ''; ?>">
	<?php $nl_bg = kawami_field_image( 'kawami_nl_bg_image' ); if ( $nl_bg ) : ?>
		<div style="position: absolute; inset: 0; background: url('<?php echo esc_url( $nl_bg ); ?>') center/cover"></div>
		<div style="position: absolute; inset: 0; background: rgba(253,243,244,.55)"></div>
	<?php endif; ?>
	<div style="position: relative; max-width: 680px; margin: 0 auto; padding: 56px 40px; text-align: center">
		<div style="display: inline-block; background: var(--k-pink-soft); border: 1.5px solid var(--k-pink); border-radius: 24px; padding: 34px 40px; box-shadow: 0 10px 30px rgba(197,93,120,.28)">
			<div style="font-size: 30px; margin-bottom: 8px">💌</div>
			<h2 style="font: 900 26px var(--k-font-title); color: var(--k-text); margin: 0 0 10px"><?php echo esc_html( kawami_field( 'kawami_nl_title' ) ); ?></h2>
			<p style="font: 500 14px/1.6 var(--k-font-ui); color: #8a5f70; margin: 0 0 22px"><?php echo esc_html( kawami_field( 'kawami_nl_text' ) ); ?></p>
			<?php if ( isset( $_GET['kawami_newsletter'] ) && 'ok' === $_GET['kawami_newsletter'] ) : ?>
				<p style="font: 600 12px var(--k-font-ui); color: var(--k-text)">Merci, c'est noté 🌸</p>
			<?php else : ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="k-form-row" style="display: flex; gap: 10px; max-width: 420px; margin: 0 auto">
					<input type="hidden" name="action" value="kawami_newsletter_signup">
					<?php wp_nonce_field( 'kawami_newsletter_signup', 'kawami_newsletter_nonce' ); ?>
					<input type="email" name="kawami_email" class="k-input" style="flex: 1" placeholder="ton@email.fr" required>
					<button type="submit" class="k-btn k-btn-dark">S'inscrire</button>
				</form>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
