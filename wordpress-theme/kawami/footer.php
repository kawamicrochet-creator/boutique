<?php
/**
 * Kawami footer. Mirrors kawami-footer.liquid.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$shop_url        = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$accessoires_url = kawami_nav_page_url( 'kawami_page_accessoires' );
$journaux_url    = kawami_nav_page_url( 'kawami_page_journaux' );
$apropos_url     = kawami_nav_page_url( 'kawami_page_apropos' );
$contact_url     = kawami_nav_page_url( 'kawami_page_contact' );
$instagram_url   = get_theme_mod( 'kawami_social_instagram_url', '' );
$tiktok_url      = get_theme_mod( 'kawami_social_tiktok_url', '' );
?>
<footer class="k-footer">
	<div class="k-footer__top">
		<div>
			<div class="k-footer__brand">
				<?php if ( has_custom_logo() ) :
					$logo_id  = get_theme_mod( 'custom_logo' );
					$logo_src = wp_get_attachment_image_src( $logo_id, 'full' );
				?>
					<img src="<?php echo esc_url( $logo_src[0] ); ?>" alt="">
				<?php endif; ?>
				<span style="font: 900 18px var(--k-font-title); color: #fff; letter-spacing: .06em">
					<?php echo esc_html( strtoupper( get_bloginfo( 'name' ) ?: 'KAWAMI' ) ); ?>
					<span style="font: 500 11px var(--k-font-title); color: var(--k-pink); letter-spacing: .3em; margin-left: 4px">親友</span>
				</span>
			</div>
			<p style="font: 500 12.5px/1.6 var(--k-font-ui); color: #c7a8b6; margin: 0; max-width: 260px"><?php echo esc_html( kawami_field( 'kawami_footer_tagline' ) ); ?></p>
		</div>
		<div>
			<div class="k-footer__heading">Boutique</div>
			<div class="k-footer__links">
				<a href="<?php echo esc_url( $shop_url ); ?>">Toutes les peluches</a>
				<?php if ( $accessoires_url ) : ?><a href="<?php echo esc_url( $accessoires_url ); ?>">Accessoires</a><?php endif; ?>
				<?php if ( $journaux_url ) : ?><a href="<?php echo esc_url( $journaux_url ); ?>">Journaux</a><?php endif; ?>
			</div>
		</div>
		<div>
			<div class="k-footer__heading">Infos</div>
			<div class="k-footer__links">
				<?php if ( $apropos_url ) : ?><a href="<?php echo esc_url( $apropos_url ); ?>">Mon histoire</a><?php endif; ?>
				<?php if ( $contact_url ) : ?><a href="<?php echo esc_url( $contact_url ); ?>">Contact</a><?php endif; ?>
			</div>
		</div>
		<div>
			<div class="k-footer__heading">Suis l'atelier</div>
			<div class="k-footer__links">
				<?php if ( $instagram_url ) : ?><a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener">Instagram</a><?php endif; ?>
				<?php if ( $tiktok_url ) : ?><a href="<?php echo esc_url( $tiktok_url ); ?>" target="_blank" rel="noopener">TikTok</a><?php endif; ?>
			</div>
		</div>
	</div>
	<div class="k-footer__bottom">© <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ?: 'Kawami' ); ?> · <?php echo esc_html( kawami_field( 'kawami_footer_signature' ) ); ?></div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
