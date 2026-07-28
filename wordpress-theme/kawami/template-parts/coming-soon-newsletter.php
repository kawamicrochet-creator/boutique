<?php
/**
 * Shared "coming soon" newsletter CTA block, used by page-accessoires.php
 * and page-journaux.php. Expects $args = ['title' => ..., 'text' => ...].
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$title    = $args['title'] ?? "Sois la première prévenue du lancement";
$text     = $args['text'] ?? '';
$bg_image = $args['bg_image'] ?? '';
$bg_style = $bg_image
	? sprintf( "background: url('%s') center 22%%/cover", esc_url( $bg_image ) )
	: 'background: var(--k-pink-soft)';
?>
<section style="max-width: 1080px; margin: 0 auto; padding: 44px 40px 64px">
	<div style="position: relative; <?php echo $bg_style; ?>; border-radius: 28px; overflow: hidden; padding: 48px 40px; text-align: center">
		<?php if ( $bg_image ) : ?>
			<div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(253,241,244,.62), rgba(253,241,244,.42))"></div>
		<?php endif; ?>
		<div class="k-anim-twinkle" style="position: absolute; left: 34px; top: 26px; font-size: 22px">✨</div>
		<div class="k-anim-twinkle" style="position: absolute; right: 40px; bottom: 30px; font-size: 20px; animation-delay: 1s">🌸</div>
		<div style="font-size: 32px; margin-bottom: 8px">💌</div>
		<h2 style="font: 900 28px var(--k-font-title); color: var(--k-text); margin: 0 0 10px"><?php echo esc_html( $title ); ?></h2>
		<p style="font: 500 14.5px/1.6 var(--k-font-ui); color: #8a5f70; margin: 0 auto 24px; max-width: 460px"><?php echo esc_html( $text ); ?></p>
		<?php if ( isset( $_GET['kawami_newsletter'] ) && 'ok' === $_GET['kawami_newsletter'] ) : ?>
			<p style="font: 600 12px var(--k-font-ui); color: var(--k-text)">Merci, c'est noté 🌸</p>
		<?php else : ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="k-form-row" style="display: flex; gap: 10px; max-width: 440px; margin: 0 auto">
				<input type="hidden" name="action" value="kawami_newsletter_signup">
				<?php wp_nonce_field( 'kawami_newsletter_signup', 'kawami_newsletter_nonce' ); ?>
				<input type="email" name="kawami_email" class="k-input" style="flex: 1" placeholder="ton@email.fr" required>
				<button type="submit" class="k-btn k-btn-dark">Me prévenir</button>
			</form>
		<?php endif; ?>
	</div>
</section>
