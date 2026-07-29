<?php
/**
 * Contact page. Create a WordPress page with the slug "contact" and it
 * will automatically use this template. The form posts to admin-post.php
 * (see kawami_handle_contact_form() in functions.php) and sends a plain
 * wp_mail() - no contact-form plugin required.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$contact_email = get_theme_mod( 'kawami_contact_email', get_option( 'admin_email' ) );
$instagram_url = get_theme_mod( 'kawami_social_instagram_url', '' );
$tiktok_url    = get_theme_mod( 'kawami_social_tiktok_url', '' );

$faqs = array(
	array( 'q' => kawami_field( 'kawami_contact_faq1_q' ), 'a' => kawami_field( 'kawami_contact_faq1_a' ) ),
	array( 'q' => kawami_field( 'kawami_contact_faq2_q' ), 'a' => kawami_field( 'kawami_contact_faq2_a' ) ),
	array( 'q' => kawami_field( 'kawami_contact_faq3_q' ), 'a' => kawami_field( 'kawami_contact_faq3_a' ) ),
);
?>

<section style="max-width: 1000px; margin: 0 auto; padding: 48px 40px 60px">
	<h1 class="k-h1"><?php echo esc_html( kawami_field( 'kawami_contact_h1' ) ); ?></h1>
	<p class="k-lead" style="margin: 0 0 30px; max-width: 520px"><?php echo esc_html( kawami_field( 'kawami_contact_intro' ) ); ?></p>

	<div class="k-grid k-grid-2 k-split" style="grid-template-columns: 1.15fr .85fr; align-items: start">
		<div style="background: var(--k-card); border: 1.5px solid var(--k-border); border-radius: 24px; padding: 30px 32px">
			<?php if ( isset( $_GET['kawami_contact'] ) && 'ok' === $_GET['kawami_contact'] ) : ?>
				<p style="font: 700 15px var(--k-font-ui); color: var(--k-text)">Merci, ton message est bien parti 🌸 Je te réponds vite !</p>
			<?php else : ?>
				<?php if ( isset( $_GET['kawami_contact'] ) && 'error' === $_GET['kawami_contact'] ) : ?>
					<p style="font: 600 13px var(--k-font-ui); color: #a94f6e; margin-bottom: 12px">Une erreur est survenue, réessaie ou écris directement à <?php echo esc_html( $contact_email ); ?>.</p>
				<?php endif; ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="k-contact-form">
					<input type="hidden" name="action" value="kawami_contact_form">
					<?php wp_nonce_field( 'kawami_contact_form', 'kawami_contact_nonce' ); ?>
					<div class="k-grid k-grid-2" style="margin-bottom: 14px">
						<div>
							<div style="font: 700 12px var(--k-font-ui); color: var(--k-text); margin-bottom: 6px">Nom</div>
							<input type="text" class="k-field" name="kawami_name" placeholder="Sakura">
						</div>
						<div>
							<div style="font: 700 12px var(--k-font-ui); color: var(--k-text); margin-bottom: 6px">Email</div>
							<input type="email" class="k-field" name="kawami_email" placeholder="toi@email.fr" required>
						</div>
					</div>
					<div style="margin-bottom: 14px">
						<div style="font: 700 12px var(--k-font-ui); color: var(--k-text); margin-bottom: 6px">Sujet</div>
						<select name="kawami_subject" class="k-field">
							<option>Une question</option>
							<option>Ma commande</option>
							<option>Précommande</option>
							<option>Presse / collab</option>
						</select>
					</div>
					<div style="margin-bottom: 16px">
						<div style="font: 700 12px var(--k-font-ui); color: var(--k-text); margin-bottom: 6px">Message</div>
						<textarea class="k-field" name="kawami_message" placeholder="Écris-moi ici..." required></textarea>
					</div>
					<button type="submit" class="k-btn k-btn-primary" style="width: 100%">Envoyer</button>
				</form>
			<?php endif; ?>
		</div>
		<div style="display: flex; flex-direction: column; gap: 16px">
			<div style="background: var(--k-card); border: 1.5px solid var(--k-border); border-radius: 20px; padding: 22px 24px">
				<div style="font: 700 15px var(--k-font-title); color: var(--k-text); margin-bottom: 10px"><?php echo esc_html( kawami_field( 'kawami_contact_social_title' ) ); ?></div>
				<div style="display: flex; flex-direction: column; gap: 9px; font: 500 13.5px var(--k-font-ui); color: var(--k-text-soft)">
					<?php if ( $contact_email ) : ?><div>📮 <?php echo esc_html( $contact_email ); ?></div><?php endif; ?>
					<?php if ( $instagram_url ) : ?><div>📸 <a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener">Instagram</a></div><?php endif; ?>
					<?php if ( $tiktok_url ) : ?><div>🎵 <a href="<?php echo esc_url( $tiktok_url ); ?>" target="_blank" rel="noopener">TikTok</a></div><?php endif; ?>
				</div>
			</div>
			<div style="background: var(--k-card); border: 1.5px solid var(--k-border); border-radius: 20px; padding: 22px 24px">
				<div style="font: 700 15px var(--k-font-title); color: var(--k-text); margin-bottom: 10px"><?php echo esc_html( kawami_field( 'kawami_contact_faq_title' ) ); ?></div>
				<div style="display: flex; flex-direction: column; gap: 12px; font: 500 13px/1.55 var(--k-font-ui); color: var(--k-text-soft)">
					<?php foreach ( $faqs as $faq ) : ?>
						<div><strong style="color: var(--k-text)"><?php echo esc_html( $faq['q'] ); ?></strong><br><?php echo esc_html( $faq['a'] ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
			<div style="background: var(--k-pink-soft); border-radius: 20px; padding: 20px 24px; font: 600 13px/1.6 var(--k-font-ui); color: var(--k-text)"><?php echo esc_html( kawami_field( 'kawami_contact_tip' ) ); ?></div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
