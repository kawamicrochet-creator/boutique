<?php
/**
 * "Accessoires" coming-soon page. Create a WordPress page with the slug
 * "accessoires" and it will automatically use this template.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$image = kawami_field_image( 'kawami_acc_image' );

$categories = array(
	array( 'icon' => '🌷', 'name' => 'Trousses de toilette' ),
	array( 'icon' => '📚', 'name' => 'Housses de livre' ),
	array( 'icon' => '💻', 'name' => "Housses d'ordinateur" ),
	array( 'icon' => '👜', 'name' => 'Totes bags matelassés' ),
);
?>

<section style="max-width: 1080px; margin: 0 auto; padding: 60px 40px 30px; text-align: center">
	<div class="k-eyebrow" style="margin-bottom: 20px">🌸 Bientôt disponible</div>
	<h1 style="font: 900 46px/1.18 var(--k-font-title); color: var(--k-text); margin: 0 0 16px; text-wrap: pretty">Les accessoires cousus main<br><span class="k-italic-accent" style="color: var(--k-beige-deep); font-size: 46px">arrivent bientôt</span></h1>
	<p class="k-lead" style="font-size: 16px; margin: 0 auto 30px; max-width: 560px">Trousses de toilette, housses pour livres et ordinateurs, totes bags matelassés — des accessoires aux tissus fleuris et romantiques, cousus à la main en petite série. La collection se prépare dans l'atelier 🪡</p>
</section>

<?php if ( $image ) : ?>
<section style="max-width: 1080px; margin: 0 auto; padding: 0 40px 20px">
	<div style="position: relative; border-radius: 30px; overflow: hidden; border: 10px solid #fff; box-shadow: 0 20px 50px rgba(92,67,81,.18)">
		<img src="<?php echo esc_url( $image ); ?>" style="display: block; width: 100%; height: 520px; object-fit: cover" alt="">
		<div style="position: absolute; left: 22px; bottom: 22px; background: rgba(253,243,244,.92); border: 1.5px solid var(--k-pink); border-radius: 999px; padding: 10px 20px; box-shadow: 0 6px 16px rgba(92,67,81,.14)" class="k-italic-accent">
			<span style="color: var(--k-beige-darker); font-size: 15px">cousu main, en petite série 🪡</span>
		</div>
	</div>
</section>
<?php endif; ?>

<section style="max-width: 1080px; margin: 0 auto; padding: 34px 40px 10px">
	<div class="k-grid k-grid-4">
		<?php foreach ( $categories as $cat ) : ?>
			<div style="background: var(--k-card); border: 1.5px solid var(--k-border); border-radius: 20px; padding: 22px 18px; text-align: center">
				<div style="font-size: 26px; margin-bottom: 8px"><?php echo esc_html( $cat['icon'] ); ?></div>
				<div style="font: 700 14px var(--k-font-title); color: var(--k-text)"><?php echo esc_html( $cat['name'] ); ?></div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<?php get_template_part( 'template-parts/coming-soon', 'newsletter', array(
	'title' => 'Sois la première prévenue du lancement',
	'text'  => "Inscris-toi à la petite lettre de l'atelier : tu sauras dès que la collection d'accessoires sera en ligne (promis, pas de spam — juste de la douceur).",
) ); ?>

<?php get_footer(); ?>
