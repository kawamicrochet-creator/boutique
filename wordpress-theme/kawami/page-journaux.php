<?php
/**
 * "Journaux" coming-soon page ("Esprits Divergents"). Create a
 * WordPress page with the slug "journaux" and it will automatically use
 * this template. Mirrors the current Shopify kawami-journaux.liquid.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$hero_image = kawami_field_image( 'kawami_jr_image' );

$benefits = array(
	array( 'emoji' => '🌿', 'bg' => '#bfe3d2', 'title' => 'Apaiser le mental', 'text' => 'Poser ses pensées sur le papier libère la tête et calme les journées agitées.' ),
	array( 'emoji' => '💗', 'bg' => '#f8cdd8', 'title' => 'Cultiver la gratitude', 'text' => 'Noter une petite joie chaque jour aide à voir le beau, même les jours gris.' ),
	array( 'emoji' => '📚', 'bg' => '#d5c3e8', 'title' => 'Garder une trace', 'text' => 'Tes lectures, tes projets, tes envies — tout au même endroit, joliment.' ),
	array( 'emoji' => '🌸', 'bg' => '#fce3c8', 'title' => 'Un moment pour soi', 'text' => 'Un rituel doux, sans pression, rien qu\'à toi. Du self-care en quelques minutes.' ),
);
$premiers = array(
	array( 'name' => 'Mon Journal de Gratitude', 'sous' => 'cultiver la gratitude, enrichir chaque jour', 'desc' => 'Chaque jour, quelques lignes pour cultiver la douceur : humeur, gratitude et petites victoires, guidé par de tendres illustrations.', 'image' => kawami_field_image( 'kawami_jr_gratitude_image' ) ),
	array( 'name' => 'Journal de mes Lectures', 'sous' => 'pour les amoureux des livres', 'desc' => "Note tes lectures, tes citations préférées, tes avis et ta PAL — un carnet cosy pour garder en mémoire tes meilleurs moments de lecture.", 'image' => kawami_field_image( 'kawami_jr_lectures_image' ) ),
);
$a_venir = array(
	array( 'emoji' => '🫧', 'bg' => '#d5c3e8', 'name' => "Journal d'anxiété", 'desc' => 'Un carnet doux pour accueillir ses émotions, repérer ses déclencheurs et respirer.' ),
	array( 'emoji' => '☀️', 'bg' => '#bfe3d2', 'name' => 'Journal quotidien — parents occupés', 'desc' => 'Un format rapide et bienveillant pour les journées bien remplies, pensé pour les parents.' ),
);
$goodies = array(
	array( 'emoji' => '🔖', 'bg' => '#f8cdd8', 'name' => 'Repère-pages', 'text' => 'marque-pages en tissu fleuri, cousus main.' ),
	array( 'emoji' => '📖', 'bg' => '#d5c3e8', 'name' => 'Book sleeves', 'text' => 'housses matelassées pour protéger tes livres.' ),
	array( 'emoji' => '✏️', 'bg' => '#bfe3d2', 'name' => 'Marqueurs', 'text' => 'jolis marqueurs assortis à tes carnets.' ),
);
?>

<section class="k-container" style="padding: 44px 40px 0">
	<div class="k-breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Accueil</a> <span style="opacity: .5">›</span>
		<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>">Boutique</a> <span style="opacity: .5">›</span>
		Journaux
	</div>
</section>

<section class="k-container" style="padding: 0 40px 30px">
	<div class="k-journal-hero" style="position: relative; height: 540px; border-radius: 30px; overflow: hidden; border: 10px solid #fff; box-shadow: 0 18px 44px rgba(92,67,81,.16)">
		<?php if ( $hero_image ) : ?>
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="Esprits Divergents" style="display: block; width: 100%; height: 100%; object-fit: cover; object-position: center 40%">
		<?php else : ?>
			<div style="width: 100%; height: 100%; background: var(--k-pink-soft)"></div>
		<?php endif; ?>
		<div style="position: absolute; inset: 0; background: linear-gradient(90deg, rgba(52,36,44,.85), rgba(52,36,44,.6) 45%, rgba(52,36,44,.2) 70%, transparent)"></div>
		<div class="k-journal-hero__overlay" style="position: absolute; left: 0; top: 0; bottom: 0; max-width: 600px; padding: 0 8%; display: flex; flex-direction: column; justify-content: center; gap: 14px">
			<div style="display: inline-flex; align-self: flex-start; align-items: center; gap: 8px; background: rgba(253,243,244,.92); border-radius: 999px; padding: 7px 16px; font: 700 11px var(--k-font-ui); letter-spacing: .18em; color: #c76b88; text-transform: uppercase">🌸 À venir prochainement</div>
			<h1 class="k-journal-hero__title" style="font: 900 46px/1.16 var(--k-font-title); color: #fff; margin: 0; text-wrap: pretty; text-shadow: 0 2px 14px rgba(0,0,0,.35)">Esprits Divergents</h1>
			<div class="k-italic-accent k-journal-hero__subtitle" style="font-size: 21px; color: #fff; text-shadow: 0 2px 10px rgba(0,0,0,.35)">une collection de journaux doux, bientôt chez toi 🌸</div>
			<p style="font: 500 14px/1.6 var(--k-font-ui); color: #fff; margin: 0; max-width: 460px; text-shadow: 0 1px 8px rgba(0,0,0,.3)">Des carnets pensés pour ralentir, respirer et prendre soin de soi — illustrés dans l'univers tendre de Kawami.</p>
		</div>
	</div>
</section>

<section class="k-container" style="padding: 20px 40px 10px">
	<div style="text-align: center; max-width: 640px; margin: 0 auto 26px">
		<h2 style="font: 900 30px var(--k-font-title); color: var(--k-text); margin: 0 0 10px">Pourquoi tenir un journal ? ✿</h2>
		<p style="font: 500 14px/1.7 var(--k-font-ui); color: var(--k-text-soft); margin: 0">Écrire quelques minutes par jour, c'est un petit geste de douceur envers soi. Nos journaux t'accompagnent avec bienveillance, sans pression ni performance.</p>
	</div>
	<div class="k-grid k-grid-4" style="align-items: stretch">
		<?php foreach ( $benefits as $b ) : ?>
			<div style="background: var(--k-card); border: 1.5px solid var(--k-border); border-radius: 20px; padding: 22px 20px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center">
				<div style="width: 52px; height: 52px; margin: 0 auto 12px; border-radius: 50%; background: <?php echo esc_attr( $b['bg'] ); ?>; display: flex; align-items: center; justify-content: center; font-size: 24px"><?php echo esc_html( $b['emoji'] ); ?></div>
				<div style="font: 700 15px var(--k-font-title); color: var(--k-text); margin-bottom: 5px"><?php echo esc_html( $b['title'] ); ?></div>
				<div style="font: 500 12.5px/1.55 var(--k-font-ui); color: var(--k-text-soft)"><?php echo esc_html( $b['text'] ); ?></div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section class="k-container" style="padding: 44px 40px 10px">
	<div style="display: flex; align-items: baseline; gap: 14px; margin-bottom: 6px; flex-wrap: wrap">
		<h2 style="font: 900 26px var(--k-font-title); color: var(--k-text); margin: 0">Les tout premiers 🌷</h2>
		<span style="font: 600 13px var(--k-font-ui); color: var(--k-text-muted)">disponibles au lancement</span>
	</div>
	<p style="font: 500 13.5px var(--k-font-ui); color: var(--k-text-soft); margin: 0 0 22px">Deux carnets pour commencer en douceur — en numérique à imprimer, ou en joli carnet papier.</p>
	<div class="k-grid k-grid-2" style="align-items: stretch">
		<?php foreach ( $premiers as $j ) : ?>
			<div style="background: var(--k-card); border: 1.5px solid var(--k-border); border-radius: 24px; overflow: hidden; display: flex; flex-wrap: wrap">
				<div class="k-journal-card__media" style="flex: 44 1 220px; min-height: 240px; position: relative; overflow: hidden; background: var(--k-beige)">
					<?php if ( ! empty( $j['image'] ) ) : ?>
						<img src="<?php echo esc_url( $j['image'] ); ?>" alt="<?php echo esc_attr( $j['name'] ); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover">
					<?php endif; ?>
					<div style="position: absolute; top: 12px; left: 12px; font: 700 10px var(--k-font-ui); letter-spacing: .05em; color: #5b4479; background: var(--k-lavender); padding: 5px 10px; border-radius: 999px">Bientôt</div>
				</div>
				<div style="flex: 56 1 220px; padding: 22px 22px 20px; display: flex; flex-direction: column">
					<div style="font: 700 19px var(--k-font-title); color: var(--k-text)"><?php echo esc_html( $j['name'] ); ?></div>
					<div style="font: 500 12px var(--k-font-ui); color: var(--k-text-muted); margin: 3px 0 10px"><?php echo esc_html( $j['sous'] ); ?></div>
					<div style="font: 500 13px/1.6 var(--k-font-ui); color: var(--k-text-soft); margin-bottom: 16px"><?php echo esc_html( $j['desc'] ); ?></div>
					<a href="#" class="k-btn k-btn-primary" style="margin-top: auto; text-align: center">Bientôt disponible</a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section class="k-container" style="padding: 40px 40px 10px">
	<div style="display: flex; align-items: baseline; gap: 14px; margin-bottom: 18px; flex-wrap: wrap">
		<h2 style="font: 900 26px var(--k-font-title); color: var(--k-text); margin: 0">Et bientôt d'autres… 💫</h2>
		<span style="font: 600 13px var(--k-font-ui); color: var(--k-text-muted)">en préparation dans l'atelier</span>
	</div>
	<div class="k-grid k-grid-2">
		<?php foreach ( $a_venir as $v ) : ?>
			<div style="background: var(--k-card); border: 1.5px dashed #e6c6d2; border-radius: 22px; padding: 22px 24px; display: flex; gap: 16px; align-items: center; flex-wrap: wrap">
				<div style="width: 56px; height: 56px; flex: none; border-radius: 16px; background: <?php echo esc_attr( $v['bg'] ); ?>; display: flex; align-items: center; justify-content: center; font-size: 26px"><?php echo esc_html( $v['emoji'] ); ?></div>
				<div style="flex: 1; min-width: 160px">
					<div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap">
						<span style="font: 700 17px var(--k-font-title); color: var(--k-text)"><?php echo esc_html( $v['name'] ); ?></span>
						<span style="font: 700 9.5px var(--k-font-ui); letter-spacing: .06em; color: var(--k-beige-darker); background: var(--k-beige); padding: 3px 9px; border-radius: 999px; text-transform: uppercase">À venir</span>
					</div>
					<div style="font: 500 12.5px/1.55 var(--k-font-ui); color: var(--k-text-soft); margin-top: 4px"><?php echo esc_html( $v['desc'] ); ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section class="k-container" style="padding: 44px 40px 10px">
	<div style="display: flex; align-items: baseline; gap: 14px; margin-bottom: 6px">
		<h2 style="font: 900 26px var(--k-font-title); color: var(--k-text); margin: 0">À assortir avec des goodies 🪡</h2>
	</div>
	<p style="font: 500 13.5px var(--k-font-ui); color: var(--k-text-soft); margin: 0 0 22px">Pour prendre soin de tes carnets et de tes livres, des petits accessoires en tissu fleuri, à venir aussi.</p>
	<div class="k-grid k-grid-3">
		<?php foreach ( $goodies as $g ) : ?>
			<div style="background: var(--k-card); border: 1.5px solid var(--k-border); border-radius: 22px; padding: 24px 22px; text-align: center">
				<div style="width: 56px; height: 56px; margin: 0 auto 12px; border-radius: 50%; background: <?php echo esc_attr( $g['bg'] ); ?>; display: flex; align-items: center; justify-content: center; font-size: 26px"><?php echo esc_html( $g['emoji'] ); ?></div>
				<div style="font: 700 15px var(--k-font-title); color: var(--k-text); margin-bottom: 4px"><?php echo esc_html( $g['name'] ); ?></div>
				<div style="font: 500 12.5px/1.55 var(--k-font-ui); color: var(--k-text-soft)"><?php echo esc_html( $g['text'] ); ?></div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<?php get_template_part( 'template-parts/coming-soon', 'newsletter', array(
	'title' => 'Sois au courant du lancement',
	'text'  => 'Inscris-toi à la petite lettre de l\'atelier : tu sauras dès que les premiers journaux seront disponibles (et tu recevras des pages bonus à imprimer 🎁).',
) ); ?>

<?php get_footer(); ?>
