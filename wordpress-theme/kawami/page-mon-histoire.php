<?php
/**
 * "Mon histoire" page. Create a WordPress page with the slug
 * "mon-histoire" and it will automatically use this template.
 * Mirrors kawami-story.liquid; edit the text below directly (photos are
 * swappable in Personnaliser > Page — Mon histoire).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$portrait  = kawami_field_image( 'kawami_story_portrait' );
$companion = kawami_field_image( 'kawami_story_companion_image' );

$values = array(
	array( 'icon' => '🎀', 'bg' => '#f8cdd8', 'title' => kawami_field( 'kawami_story_value1_title' ), 'text' => kawami_field( 'kawami_story_value1_text' ) ),
	array( 'icon' => '🌿', 'bg' => '#bfe3d2', 'title' => kawami_field( 'kawami_story_value2_title' ), 'text' => kawami_field( 'kawami_story_value2_text' ) ),
	array( 'icon' => '💌', 'bg' => '#d5c3e8', 'title' => kawami_field( 'kawami_story_value3_title' ), 'text' => kawami_field( 'kawami_story_value3_text' ) ),
);
?>

<section class="k-split" style="max-width: 1000px; margin: 0 auto; padding: 52px 40px 20px; display: grid; grid-template-columns: .85fr 1.15fr; gap: 52px; align-items: center">
	<div style="position: relative">
		<div class="k-photo-frame k-rotate-n2" style="aspect-ratio: .85">
			<?php if ( $portrait ) : ?><img src="<?php echo esc_url( $portrait ); ?>" style="width: 100%; height: 100%; object-fit: cover" alt=""><?php endif; ?>
		</div>
		<div style="position: absolute; right: -8px; bottom: -12px; background: var(--k-pink-soft); border-radius: 999px; padding: 10px 18px; font: 700 12.5px var(--k-font-ui); color: var(--k-text); transform: rotate(3deg); box-shadow: 0 6px 16px rgba(92,67,81,.15)"><?php echo esc_html( kawami_field( 'kawami_story_photo_tag' ) ); ?></div>
	</div>
	<div>
		<div style="font: 700 12px var(--k-font-ui); letter-spacing: .22em; color: var(--k-text-muted); text-transform: uppercase; margin-bottom: 12px"><?php echo esc_html( kawami_field( 'kawami_story_eyebrow' ) ); ?></div>
		<h1 style="font: 900 40px/1.2 var(--k-font-title); color: var(--k-text); margin: 0 0 16px; text-wrap: pretty"><?php echo esc_html( kawami_field( 'kawami_story_h1' ) ); ?></h1>
		<p class="k-lead" style="font-size: 15px; line-height: 1.75; margin: 0 0 12px"><?php echo esc_html( kawami_field( 'kawami_story_paragraph_1' ) ); ?></p>
		<p class="k-lead" style="font-size: 15px; line-height: 1.75; margin: 0"><?php echo esc_html( kawami_field( 'kawami_story_paragraph_2' ) ); ?></p>
	</div>
</section>

<section style="max-width: 1000px; margin: 0 auto; padding: 44px 40px 10px">
	<div style="background: var(--k-card); border: 1.5px solid var(--k-border); border-radius: 22px; padding: 24px 28px; display: flex; gap: 24px; align-items: center; flex-wrap: wrap; margin-bottom: 22px">
		<div style="width: 150px; height: 150px; border-radius: 50%; overflow: hidden; border: 4px solid var(--k-pink-soft); flex: none">
			<?php if ( $companion ) : ?><img src="<?php echo esc_url( $companion ); ?>" style="width: 100%; height: 100%; object-fit: cover" alt=""><?php endif; ?>
		</div>
		<div style="flex: 1; min-width: 260px">
			<div style="font: 700 18px var(--k-font-title); color: var(--k-text); margin-bottom: 4px"><?php echo esc_html( kawami_field( 'kawami_story_companion_name' ) ); ?></div>
			<div style="font: 700 11px var(--k-font-ui); letter-spacing: .14em; text-transform: uppercase; color: var(--k-text-muted); margin-bottom: 8px"><?php echo esc_html( kawami_field( 'kawami_story_companion_role' ) ); ?></div>
			<div style="font: 500 14px/1.65 var(--k-font-ui); color: var(--k-text-soft)"><?php echo esc_html( kawami_field( 'kawami_story_companion_text' ) ); ?></div>
		</div>
	</div>

	<div class="k-callout" style="background: var(--k-pink-soft)">
		<div class="k-callout__icon">💕</div>
		<div style="flex: 1; min-width: 280px; font: 600 14px/1.65 var(--k-font-ui); color: var(--k-text)"><?php echo esc_html( kawami_field( 'kawami_story_callout_text' ) ); ?></div>
	</div>

	<div class="k-grid k-grid-3" style="margin-top: 26px">
		<?php foreach ( $values as $value ) : ?>
			<div style="background: var(--k-card); border: 1.5px solid var(--k-border); border-radius: 22px; padding: 24px 22px">
				<div style="width: 44px; height: 44px; border-radius: 50%; background: <?php echo esc_attr( $value['bg'] ); ?>; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 12px"><?php echo esc_html( $value['icon'] ); ?></div>
				<div style="font: 700 16px var(--k-font-title); color: var(--k-text); margin-bottom: 6px"><?php echo esc_html( $value['title'] ); ?></div>
				<div style="font: 500 13px/1.6 var(--k-font-ui); color: var(--k-text-soft)"><?php echo esc_html( $value['text'] ); ?></div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section style="max-width: 1000px; margin: 0 auto; padding: 10px 40px 56px">
	<div style="background: var(--k-card); border: 1.5px solid var(--k-border); border-radius: 26px; padding: 34px 38px; display: flex; gap: 24px; align-items: center; flex-wrap: wrap">
		<div style="font-size: 34px">⛩️</div>
		<div style="flex: 1; min-width: 280px">
			<div style="font: 700 18px var(--k-font-title); color: var(--k-text); margin-bottom: 6px"><?php echo esc_html( kawami_field( 'kawami_story_meetup_title' ) ); ?></div>
			<div style="font: 500 14px/1.65 var(--k-font-ui); color: var(--k-text-soft)"><?php echo esc_html( kawami_field( 'kawami_story_meetup_text' ) ); ?></div>
		</div>
		<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>" class="k-btn k-btn-primary">Visiter la boutique</a>
	</div>
</section>

<?php get_footer(); ?>
