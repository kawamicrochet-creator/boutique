<?php
/**
 * Kawami theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'KAWAMI_VERSION', '1.0.0' );

function kawami_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 112,
		'width'       => 112,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'automatic-feed-links' );

	// WooCommerce
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( array(
		'primary' => __( 'Menu principal', 'kawami' ),
		'footer'  => __( 'Menu du pied de page', 'kawami' ),
	) );
}
add_action( 'after_setup_theme', 'kawami_setup' );

function kawami_assets() {
	wp_enqueue_style(
		'kawami-fonts',
		'https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@400;500;700;900&family=Quicksand:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&display=swap',
		array(),
		null
	);
	// Use the file's last-modified time as the version string instead of a
	// fixed constant, so editing style.css (or the header script) always
	// busts any browser/server cache automatically - no more stale CSS
	// after an update.
	$style_path = get_stylesheet_directory() . '/style.css';
	wp_enqueue_style( 'kawami-style', get_stylesheet_uri(), array( 'kawami-fonts' ), file_exists( $style_path ) ? filemtime( $style_path ) : KAWAMI_VERSION );

	$header_js_path = get_template_directory() . '/assets/js/kawami-header.js';
	wp_enqueue_script( 'kawami-header', get_template_directory_uri() . '/assets/js/kawami-header.js', array(), file_exists( $header_js_path ) ? filemtime( $header_js_path ) : KAWAMI_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'kawami_assets' );

/**
 * Availability badge (En stock / Précommande / Épuisé), mirrors the
 * Shopify build's rule: a "precommande" tag always wins, otherwise a
 * product that's purchasable with zero tracked stock (backorders
 * allowed) is a preorder, out of stock is "Épuisé", anything else is
 * "En stock".
 */
function kawami_availability_badge( $product, $extra_class = 'k-card__badge' ) {
	if ( ! $product instanceof WC_Product ) {
		return '';
	}
	$extra_class = $extra_class ? ' ' . $extra_class : '';

	// WooCommerce has three stock statuses, not two: 'instock', 'outofstock',
	// and 'onbackorder' - a 0-qty product with backorders allowed is
	// 'onbackorder', which is_in_stock() reports as NOT in stock (it only
	// checks for 'instock'), so checking is_in_stock() first wrongly
	// classified backorder-allowed products as sold out.
	$stock_status = $product->get_stock_status();

	if ( has_term( 'precommande', 'product_tag', $product->get_id() ) || 'onbackorder' === $stock_status ) {
		$state = 'preorder';
	} elseif ( 'outofstock' === $stock_status ) {
		$state = 'soldout';
	} else {
		$state = 'instock';
	}

	switch ( $state ) {
		case 'preorder':
			$delay = get_theme_mod( 'kawami_preorder_delay_text', '2-3 semaines' );
			return '<div class="k-badge k-badge-preorder' . esc_attr( $extra_class ) . '">Précommande · ' . esc_html( $delay ) . '</div>';
		case 'soldout':
			return '<div class="k-badge' . esc_attr( $extra_class ) . '" style="background:var(--k-border);color:var(--k-text)">Épuisé</div>';
		default:
			return '<div class="k-badge k-badge-instock' . esc_attr( $extra_class ) . '">En stock</div>';
	}
}

/**
 * Theme Customizer: logo/colors already come from core (custom-logo,
 * site icon); a couple of Kawami-specific text settings live here.
 */
function kawami_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'kawami_options', array(
		'title'    => __( 'Réglages Kawami', 'kawami' ),
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'kawami_preorder_delay_text', array(
		'default'           => '2-3 semaines',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'kawami_preorder_delay_text', array(
		'label'   => __( 'Délai de précommande affiché', 'kawami' ),
		'section' => 'kawami_options',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'kawami_free_shipping_threshold', array(
		'default'           => 120,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'kawami_free_shipping_threshold', array(
		'label'   => __( 'Seuil de livraison offerte (France, en €)', 'kawami' ),
		'section' => 'kawami_options',
		'type'    => 'number',
	) );

	$wp_customize->add_setting( 'kawami_contact_email', array(
		'default'           => get_option( 'admin_email' ),
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'kawami_contact_email', array(
		'label'   => __( 'Email de contact (formulaire + affiché)', 'kawami' ),
		'section' => 'kawami_options',
		'type'    => 'email',
	) );

	$wp_customize->add_setting( 'kawami_social_instagram_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'kawami_social_instagram_url', array(
		'label'   => __( 'Lien Instagram', 'kawami' ),
		'section' => 'kawami_options',
		'type'    => 'url',
	) );

	$wp_customize->add_setting( 'kawami_social_tiktok_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'kawami_social_tiktok_url', array(
		'label'   => __( 'Lien TikTok', 'kawami' ),
		'section' => 'kawami_options',
		'type'    => 'url',
	) );

	// Page pickers for the header/footer nav - same idea as the Shopify
	// build's page-picker section settings, so the merchant just selects
	// existing WordPress pages instead of hardcoding slugs.
	$nav_pages = array(
		'kawami_page_accessoires'     => __( 'Page « Accessoires »', 'kawami' ),
		'kawami_page_journaux'        => __( 'Page « Journaux »', 'kawami' ),
		'kawami_page_apropos'         => __( 'Page « Mon histoire »', 'kawami' ),
		'kawami_page_contact'         => __( 'Page « Contact »', 'kawami' ),
		'kawami_page_mentions_legales' => __( 'Page « Mentions légales »', 'kawami' ),
		'kawami_page_confidentialite'  => __( 'Page « Politique de confidentialité »', 'kawami' ),
		'kawami_page_ccv'              => __( 'Page « CGV »', 'kawami' ),
	);
	foreach ( $nav_pages as $setting_id => $label ) {
		$wp_customize->add_setting( $setting_id, array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( $setting_id, array(
			'label'   => $label,
			'section' => 'kawami_options',
			'type'    => 'dropdown-pages',
		) );
	}

	// Homepage section content - one section per Shopify section it replaces,
	// data-driven so every text/url/image field is a couple of lines instead
	// of a full add_setting()+add_control() pair each.
	foreach ( kawami_homepage_fields() as $section_id => $section ) {
		$wp_customize->add_section( $section_id, array(
			'title'    => $section['title'],
			'priority' => 40,
		) );
		foreach ( $section['fields'] as $id => $field ) {
			$setting_args = array( 'default' => $field['default'] ?? '' );
			if ( 'image' === $field['type'] ) {
				$setting_args['sanitize_callback'] = 'esc_url_raw';
			} elseif ( 'url' === $field['type'] ) {
				$setting_args['sanitize_callback'] = 'esc_url_raw';
			} elseif ( 'textarea' === $field['type'] ) {
				$setting_args['sanitize_callback'] = 'wp_kses_post';
			} else {
				$setting_args['sanitize_callback'] = 'sanitize_text_field';
			}
			$wp_customize->add_setting( $id, $setting_args );

			if ( 'image' === $field['type'] ) {
				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array(
					'label'   => $field['label'],
					'section' => $section_id,
				) ) );
			} else {
				$control_type = 'textarea' === $field['type'] ? 'textarea' : ( 'url' === $field['type'] ? 'url' : 'text' );
				$wp_customize->add_control( $id, array(
					'label'   => $field['label'],
					'section' => $section_id,
					'type'    => $control_type,
				) );
			}
		}
	}
}
add_action( 'customize_register', 'kawami_customize_register' );

/**
 * Data-driven definition of every editable homepage text/url/image field,
 * grouped by the Customizer section (= the Shopify section it replaces).
 * Read with kawami_field( $id, $default ) in front-page.php.
 */
function kawami_homepage_fields() {
	return array(
		'kawami_product_page' => array(
			'title'  => __( 'Fiche produit (tous les produits)', 'kawami' ),
			'fields' => array(
				'kawami_pp_care_banner'    => array( 'type' => 'text', 'label' => 'Bandeau (au-dessus du bouton panier)', 'default' => '🏮 Chaque pièce est crochetée à la main, prévois un léger délai de fabrication.' ),
				'kawami_pp_care1'          => array( 'type' => 'text', 'label' => 'Encadré soin — ligne 1', 'default' => 'Laine et rembourrage sans matière animale, certifiés Oeko-Tex / GOTS' ),
				'kawami_pp_care2'          => array( 'type' => 'text', 'label' => 'Encadré soin — ligne 2', 'default' => "Lavage max 40°, séchage à l'air libre" ),
				'kawami_pp_care3'          => array( 'type' => 'text', 'label' => 'Encadré soin — ligne 3', 'default' => 'Pièce unique faite main — de légères variations la rendent unique' ),
				'kawami_pp_shipping_title' => array( 'type' => 'text', 'label' => 'Accordéon « Livraison » — titre', 'default' => 'Livraison' ),
				'kawami_pp_shipping_text'  => array( 'type' => 'textarea', 'label' => 'Accordéon « Livraison » — texte', 'default' => 'Expédiée soigneusement sous 2 à 5 jours ouvrés pour les articles en stock.' ),
				'kawami_pp_preorder_title' => array( 'type' => 'text', 'label' => 'Accordéon « Précommande » — titre', 'default' => 'Précommande' ),
				'kawami_pp_preorder_text'  => array( 'type' => 'textarea', 'label' => 'Accordéon « Précommande » — texte (utilise {delai} pour le délai configuré plus haut)', 'default' => 'Les pièces en précommande sont crochetées à la main et expédiées sous {delai}.' ),
				'kawami_pp_safety_title'   => array( 'type' => 'text', 'label' => 'Accordéon « Sécurité & entretien » — titre', 'default' => 'Sécurité & entretien' ),
				'kawami_pp_safety_text'    => array( 'type' => 'textarea', 'label' => 'Accordéon « Sécurité & entretien » — texte', 'default' => 'Convient à partir de 3 ans. Lavage à la main ou en machine à 30-40°, séchage à l\'air libre.' ),
			),
		),
		'kawami_footer' => array(
			'title'  => __( 'Pied de page', 'kawami' ),
			'fields' => array(
				'kawami_footer_tagline'   => array( 'type' => 'text', 'label' => 'Texte sous le logo', 'default' => 'Peluches au crochet et accessoires cousus main, depuis un petit atelier français.' ),
				'kawami_footer_signature' => array( 'type' => 'text', 'label' => 'Fin de la ligne de copyright', 'default' => 'fait main avec 💕 et beaucoup de laine' ),
			),
		),
		'kawami_announce_bar' => array(
			'title'  => __( 'Bandeau d\'annonce (en haut du site)', 'kawami' ),
			'fields' => array(
				'kawami_announce_1' => array( 'type' => 'text', 'label' => 'Message 1', 'default' => '🌍 Livraison soignée dans le monde entier 🌍' ),
				'kawami_announce_2' => array( 'type' => 'text', 'label' => 'Message 2', 'default' => '🎁 Livraison gratuite en France dès ' . absint( get_theme_mod( 'kawami_free_shipping_threshold', 120 ) ) . ' € 🎁' ),
				'kawami_announce_3' => array( 'type' => 'text', 'label' => 'Message 3', 'default' => '🧵 Précommandes : fabrication en ' . esc_html( get_theme_mod( 'kawami_preorder_delay_text', '2-3 semaines' ) ) . ' 🧵' ),
			),
		),
		'kawami_hero' => array(
			'title'  => __( 'Accueil — Hero', 'kawami' ),
			'fields' => array(
				'kawami_hero_eyebrow'            => array( 'type' => 'text', 'label' => 'Petit texte au-dessus', 'default' => '🌸 NOUVELLE COLLECTION ÉTÉ' ),
				'kawami_hero_title'              => array( 'type' => 'text', 'label' => 'Titre', 'default' => 'Des peluches au crochet, douces comme un câlin' ),
				'kawami_hero_subtitle'           => array( 'type' => 'textarea', 'label' => 'Sous-titre', 'default' => 'Amigurumis kawaii inspirés des animés, de la k-pop et des jeux vidéo — crochetés maille par maille dans mon petit atelier.' ),
				'kawami_hero_primary_cta_text'   => array( 'type' => 'text', 'label' => 'Bouton principal', 'default' => 'Découvrir la boutique' ),
				'kawami_hero_primary_cta_url'    => array( 'type' => 'url', 'label' => 'Lien du bouton principal' ),
				'kawami_hero_secondary_cta_text' => array( 'type' => 'text', 'label' => 'Bouton secondaire', 'default' => 'Mon histoire' ),
				'kawami_hero_secondary_cta_url'  => array( 'type' => 'url', 'label' => 'Lien du bouton secondaire' ),
				'kawami_hero_image_1'            => array( 'type' => 'image', 'label' => 'Photo (grande, arrondie)' ),
				'kawami_hero_image_2'            => array( 'type' => 'image', 'label' => 'Photo (petite, ronde)' ),
				'kawami_hero_price_tag_text'     => array( 'type' => 'text', 'label' => 'Étiquette produit — nom' ),
				'kawami_hero_price_tag_price'    => array( 'type' => 'text', 'label' => 'Étiquette produit — prix' ),
				'kawami_hero_badge1_text'        => array( 'type' => 'text', 'label' => 'Badge 1 (utilise | pour la 2e ligne)', 'default' => '100% fait main|pièces uniques' ),
				'kawami_hero_badge2_text'        => array( 'type' => 'text', 'label' => 'Badge 2 (utilise | pour la 2e ligne)', 'default' => 'Laine certifiée|Oeko-Tex' ),
				'kawami_hero_badge3_text'        => array( 'type' => 'text', 'label' => 'Badge 3 (utilise | pour la 2e ligne, {delai} pour le délai configuré plus bas)', 'default' => 'Précommande|{delai}' ),
			),
		),
		'kawami_univers' => array(
			'title'  => __( 'Accueil — Mes univers', 'kawami' ),
			'fields' => array(
				'kawami_univers_title'      => array( 'type' => 'text', 'label' => 'Titre', 'default' => 'Mes univers ⛩️' ),
				'kawami_univers_subtitle'   => array( 'type' => 'text', 'label' => 'Sous-titre', 'default' => 'choisis ton fandom' ),
				'kawami_univers_categories' => array( 'type' => 'text', 'label' => 'Catégories à afficher (noms ou slugs séparés par des virgules, dans l\'ordre voulu — ex: Peluches, Kawaii, En stock — laisser vide pour un choix automatique)' ),
			),
		),
		'kawami_featured' => array(
			'title'  => __( 'Accueil — Produits en vedette', 'kawami' ),
			'fields' => array(
				'kawami_featured_title'    => array( 'type' => 'text', 'label' => 'Titre', 'default' => 'Les petites nouveautés ✨' ),
				'kawami_featured_subtitle' => array( 'type' => 'textarea', 'label' => 'Sous-titre', 'default' => "Certaines peluches partent tout de suite, d'autres sont crochetées rien que pour toi." ),
			),
		),
		'kawami_custom_order' => array(
			'title'  => __( 'Accueil — Commande personnalisée', 'kawami' ),
			'fields' => array(
				'kawami_co_eyebrow'  => array( 'type' => 'text', 'label' => 'Petit texte', 'default' => '🎨 Commande personnalisée' ),
				'kawami_co_title'    => array( 'type' => 'text', 'label' => 'Titre', 'default' => 'Ta peluche, dans tes couleurs' ),
				'kawami_co_text'     => array( 'type' => 'textarea', 'label' => 'Texte', 'default' => "Tu craques pour un de mes modèles mais tu le rêves dans d'autres teintes ? On peut adapter les couleurs d'un modèle existant rien que pour toi 💕" ),
				'kawami_co_note'     => array( 'type' => 'textarea', 'label' => 'Note encadrée', 'default' => "🧵 Je réalise uniquement des variantes de couleur sur mes modèles déjà testés — je n'accepte pas les patrons extérieurs, pour garantir la qualité de chaque pièce." ),
				'kawami_co_cta_text' => array( 'type' => 'text', 'label' => 'Bouton', 'default' => "Demander si c'est possible" ),
				'kawami_co_cta_url'  => array( 'type' => 'url', 'label' => 'Lien du bouton' ),
			),
		),
		'kawami_atelier' => array(
			'title'  => __( 'Accueil — Atelier couture (teaser)', 'kawami' ),
			'fields' => array(
				'kawami_ac_image'        => array( 'type' => 'image', 'label' => 'Photo' ),
				'kawami_ac_tag_text'     => array( 'type' => 'text', 'label' => 'Étiquette sur la photo', 'default' => 'cousu main, en petite série 🪡' ),
				'kawami_ac_eyebrow'      => array( 'type' => 'text', 'label' => 'Petit texte', 'default' => "L'atelier couture · bientôt" ),
				'kawami_ac_title'        => array( 'type' => 'text', 'label' => 'Titre', 'default' => 'Fleurs, tissus' ),
				'kawami_ac_title_accent' => array( 'type' => 'text', 'label' => 'Titre (accent italique)', 'default' => '& romantisme' ),
				'kawami_ac_text'         => array( 'type' => 'textarea', 'label' => 'Texte', 'default' => "À côté du crochet, l'atelier propose des accessoires aux tissus fleuris : trousses de toilette, housses pour livres et ordinateurs, totes bags matelassés. Chaque pièce est cousue à la main, en petite série." ),
				'kawami_ac_cta_text'     => array( 'type' => 'text', 'label' => 'Bouton', 'default' => 'Être prévenue du lancement' ),
				'kawami_ac_cta_url'      => array( 'type' => 'url', 'label' => 'Lien du bouton' ),
			),
		),
		'kawami_story' => array(
			'title'  => __( 'Accueil — Mon histoire (teaser)', 'kawami' ),
			'fields' => array(
				'kawami_st_image'     => array( 'type' => 'image', 'label' => 'Photo' ),
				'kawami_st_tag_text'  => array( 'type' => 'text', 'label' => 'Étiquette sur la photo', 'default' => 'crocheté avec amour 💕' ),
				'kawami_st_eyebrow'   => array( 'type' => 'text', 'label' => 'Petit texte', 'default' => 'Mon histoire' ),
				'kawami_st_title'     => array( 'type' => 'text', 'label' => 'Titre', 'default' => 'Derrière Kawami, il y a Savie (et beaucoup de laine)' ),
				'kawami_st_text'      => array( 'type' => 'textarea', 'label' => 'Texte', 'default' => "Kawami, c'est moi, Savannah ! Non-binaire, à mobilité réduite et atteinte de maladies chroniques, j'ai voulu offrir des amis réconfortants inspirés des univers que j'aime. Chaque vente contribue à mon confort et à mes frais médicaux. 親友, c'est « meilleur ami » : ce que chaque peluche devient en arrivant chez toi." ),
				'kawami_st_link_text' => array( 'type' => 'text', 'label' => 'Lien', 'default' => 'Lire mon histoire' ),
				'kawami_st_link_url'  => array( 'type' => 'url', 'label' => 'URL du lien' ),
			),
		),
		'kawami_instagram' => array(
			'title'  => __( 'Accueil — Instagram', 'kawami' ),
			'fields' => array(
				'kawami_ig_title' => array( 'type' => 'text', 'label' => 'Titre', 'default' => 'En ce moment sur Instagram 📸' ),
			),
		),
		'kawami_story_page' => array(
			'title'  => __( 'Page — Mon histoire', 'kawami' ),
			'fields' => array(
				'kawami_story_portrait'         => array( 'type' => 'image', 'label' => 'Photo portrait' ),
				'kawami_story_eyebrow'          => array( 'type' => 'text', 'label' => 'Petit texte au-dessus du titre', 'default' => 'Mon histoire' ),
				'kawami_story_h1'               => array( 'type' => 'text', 'label' => 'Titre', 'default' => "Coucou, moi c'est Savie 🌸" ),
				'kawami_story_paragraph_1'      => array( 'type' => 'textarea', 'label' => 'Premier paragraphe', 'default' => "Savie, c'est mon surnom — je m'appelle Savannah. Je suis non-binaire, à mobilité réduite et atteinte de maladies chroniques — et c'est moi qui m'occupe de Kawami. Grande fan d'animés et de k-pop, je voulais offrir des amis réconfortants inspirés de ces univers." ),
				'kawami_story_paragraph_2'      => array( 'type' => 'textarea', 'label' => 'Deuxième paragraphe', 'default' => "Ma famille m'épaule pour la création et la logistique, mais Kawami, c'est mon bébé : un espace bienveillant où tout le monde est accepté et bienvenu." ),
				'kawami_story_photo_tag'        => array( 'type' => 'text', 'label' => 'Étiquette sur la photo', 'default' => 'maille après maille 🎀' ),
				'kawami_story_companion_image'  => array( 'type' => 'image', 'label' => 'Photo du compagnon' ),
				'kawami_story_companion_name'   => array( 'type' => 'text', 'label' => 'Compagnon — nom', 'default' => 'Willow 🐾' ),
				'kawami_story_companion_role'   => array( 'type' => 'text', 'label' => 'Compagnon — rôle', 'default' => "Chienne d'assistance officielle" ),
				'kawami_story_companion_text'   => array( 'type' => 'textarea', 'label' => 'Compagnon — texte', 'default' => "Ma bouvier bernois, qui m'accompagne partout — et qui adore participer aux shootings photo des peluches." ),
				'kawami_story_callout_text'     => array( 'type' => 'textarea', 'label' => 'Message de remerciement (encadré rose)', 'default' => 'Chaque peluche vendue contribue directement à mon confort et aux frais médicaux de mes déplacements chez les spécialistes. Merci du fond du cœur de faire vivre Kawami.' ),
				'kawami_story_meetup_title'     => array( 'type' => 'text', 'label' => 'Bloc convention — titre', 'default' => 'On se croisera en convention !' ),
				'kawami_story_meetup_text'      => array( 'type' => 'textarea', 'label' => 'Bloc convention — texte', 'default' => "J'adore aller en convention quand mon état de santé me le permet ! Les stands Kawami font une petite pause cette année, le temps de prendre soin de moi. Rendez-vous l'année prochaine ; en attendant, la boutique en ligne reste grande ouverte 💕" ),
				'kawami_story_value1_title'     => array( 'type' => 'text', 'label' => 'Valeur 1 — titre', 'default' => '100 % fait main' ),
				'kawami_story_value1_text'      => array( 'type' => 'textarea', 'label' => 'Valeur 1 — texte', 'default' => 'Chaque peluche demande des heures de crochet. Pas deux identiques — la tienne est unique au monde.' ),
				'kawami_story_value2_title'     => array( 'type' => 'text', 'label' => 'Valeur 2 — titre', 'default' => 'Matières saines' ),
				'kawami_story_value2_text'      => array( 'type' => 'textarea', 'label' => 'Valeur 2 — texte', 'default' => 'Laine chenille certifiée Oeko-Tex et rembourrage hypoallergénique.' ),
				'kawami_story_value3_title'     => array( 'type' => 'text', 'label' => 'Valeur 3 — titre', 'default' => '親友, « meilleur ami »' ),
				'kawami_story_value3_text'      => array( 'type' => 'textarea', 'label' => 'Valeur 3 — texte', 'default' => "Le slogan de Kawami : chaque peluche est pensée pour devenir le petit compagnon qu'on garde toujours près de soi." ),
			),
		),
		'kawami_contact_page' => array(
			'title'  => __( 'Page — Contact', 'kawami' ),
			'fields' => array(
				'kawami_contact_h1'          => array( 'type' => 'text', 'label' => 'Titre', 'default' => 'Écris-moi 💌' ),
				'kawami_contact_intro'       => array( 'type' => 'textarea', 'label' => 'Texte d\'intro', 'default' => 'Une question sur une peluche, une précommande, ta commande en cours ? Je réponds en général sous 48 h (le crochet occupe beaucoup mes mains !).' ),
				'kawami_contact_social_title' => array( 'type' => 'text', 'label' => 'Encadré contacts — titre', 'default' => 'Retrouve-moi ici' ),
				'kawami_contact_faq_title'   => array( 'type' => 'text', 'label' => 'Encadré FAQ — titre', 'default' => 'Petites questions fréquentes' ),
				'kawami_contact_faq1_q'      => array( 'type' => 'text', 'label' => 'FAQ 1 — question', 'default' => 'Quel délai pour une précommande ?' ),
				'kawami_contact_faq1_a'      => array( 'type' => 'textarea', 'label' => 'FAQ 1 — réponse', 'default' => 'Fabrication en ' . esc_html( get_theme_mod( 'kawami_preorder_delay_text', '2-3 semaines' ) ) . ', puis envoi suivi sous 48 h.' ),
				'kawami_contact_faq2_q'      => array( 'type' => 'text', 'label' => 'FAQ 2 — question', 'default' => 'Cela convient-il aux enfants ?' ),
				'kawami_contact_faq2_a'      => array( 'type' => 'textarea', 'label' => 'FAQ 2 — réponse', 'default' => 'Nos peluches sont avant tout des objets de décoration et de collection. Certaines ont des yeux de sécurité (normes CE en cours) ; si c\'est pour un enfant, privilégiez les modèles aux yeux brodés.' ),
				'kawami_contact_faq3_q'      => array( 'type' => 'text', 'label' => 'FAQ 3 — question', 'default' => 'Seras-tu en convention cette année ?' ),
				'kawami_contact_faq3_a'      => array( 'type' => 'textarea', 'label' => 'FAQ 3 — réponse', 'default' => 'Pas cette année — rendez-vous l\'année prochaine 💕' ),
				'kawami_contact_tip'         => array( 'type' => 'textarea', 'label' => 'Astuce (encadré rose)', 'default' => '🌸 Astuce : pour suivre la naissance des prochaines peluches, c\'est sur Instagram que tout se passe !' ),
			),
		),
		'kawami_accessoires_page' => array(
			'title'  => __( 'Page — Accessoires (bientôt)', 'kawami' ),
			'fields' => array(
				'kawami_acc_image'         => array( 'type' => 'image', 'label' => 'Image centrale' ),
				'kawami_acc_eyebrow_text'  => array( 'type' => 'text', 'label' => 'Petit texte au-dessus', 'default' => '🌸 Bientôt disponible' ),
				'kawami_acc_h1_line1'      => array( 'type' => 'text', 'label' => 'Titre — ligne 1', 'default' => 'Les accessoires cousus main' ),
				'kawami_acc_h1_line2'      => array( 'type' => 'text', 'label' => 'Titre — ligne 2 (italique)', 'default' => 'arrivent bientôt' ),
				'kawami_acc_intro'         => array( 'type' => 'textarea', 'label' => 'Texte d\'intro', 'default' => 'Trousses de toilette, housses pour livres et ordinateurs, totes bags matelassés — des accessoires aux tissus fleuris et romantiques, cousus à la main en petite série. La collection se prépare dans l\'atelier 🪡' ),
				'kawami_acc_photo_tag'     => array( 'type' => 'text', 'label' => 'Étiquette sur la photo', 'default' => 'cousu main, en petite série 🪡' ),
				'kawami_acc_cat1'          => array( 'type' => 'text', 'label' => 'Catégorie 1', 'default' => 'Trousses de toilette' ),
				'kawami_acc_cat2'          => array( 'type' => 'text', 'label' => 'Catégorie 2', 'default' => 'Housses de livre' ),
				'kawami_acc_cat3'          => array( 'type' => 'text', 'label' => 'Catégorie 3', 'default' => "Housses d'ordinateur" ),
				'kawami_acc_cat4'          => array( 'type' => 'text', 'label' => 'Catégorie 4', 'default' => 'Totes bags matelassés' ),
				'kawami_acc_nl_title'      => array( 'type' => 'text', 'label' => 'Newsletter — titre', 'default' => 'Sois la première prévenue du lancement' ),
				'kawami_acc_nl_text'       => array( 'type' => 'textarea', 'label' => 'Newsletter — texte', 'default' => "Inscris-toi à la petite lettre de l'atelier : tu sauras dès que la collection d'accessoires sera en ligne (promis, pas de spam — juste de la douceur)." ),
			),
		),
		'kawami_journaux_page' => array(
			'title'  => __( 'Page — Journaux (bientôt)', 'kawami' ),
			'fields' => array(
				'kawami_jr_image'           => array( 'type' => 'image', 'label' => 'Image centrale (bandeau)' ),
				'kawami_jr_gratitude_image' => array( 'type' => 'image', 'label' => 'Image — Mon Journal de Gratitude' ),
				'kawami_jr_lectures_image'  => array( 'type' => 'image', 'label' => 'Image — Journal de mes Lectures' ),
				'kawami_jr_feature_image'   => array( 'type' => 'image', 'label' => 'Image — bloc « Numérique & papier » (tablette/livret)' ),
				'kawami_jr_cta_image'       => array( 'type' => 'image', 'label' => 'Photo de fond — bandeau final' ),
				'kawami_jr_hero_eyebrow'    => array( 'type' => 'text', 'label' => 'Bandeau — petit texte', 'default' => '🌸 À venir prochainement' ),
				'kawami_jr_hero_title'      => array( 'type' => 'text', 'label' => 'Bandeau — titre', 'default' => 'Esprits Divergents' ),
				'kawami_jr_hero_subtitle'   => array( 'type' => 'text', 'label' => 'Bandeau — sous-titre', 'default' => 'une collection de journaux doux, bientôt chez toi 🌸' ),
				'kawami_jr_hero_text'       => array( 'type' => 'textarea', 'label' => 'Bandeau — texte', 'default' => "Des carnets pensés pour ralentir, respirer et prendre soin de soi — illustrés dans l'univers tendre de Kawami." ),
				'kawami_jr_why_title'       => array( 'type' => 'text', 'label' => '« Pourquoi tenir un journal » — titre', 'default' => 'Pourquoi tenir un journal ? ✿' ),
				'kawami_jr_why_text'        => array( 'type' => 'textarea', 'label' => '« Pourquoi tenir un journal » — texte', 'default' => "Écrire quelques minutes par jour, c'est un petit geste de douceur envers soi. Nos journaux t'accompagnent avec bienveillance, sans pression ni performance." ),
				'kawami_jr_benefit1_title'  => array( 'type' => 'text', 'label' => 'Bienfait 1 — titre', 'default' => 'Apaiser le mental' ),
				'kawami_jr_benefit1_text'   => array( 'type' => 'textarea', 'label' => 'Bienfait 1 — texte', 'default' => 'Poser ses pensées sur le papier libère la tête et calme les journées agitées.' ),
				'kawami_jr_benefit2_title'  => array( 'type' => 'text', 'label' => 'Bienfait 2 — titre', 'default' => 'Cultiver la gratitude' ),
				'kawami_jr_benefit2_text'   => array( 'type' => 'textarea', 'label' => 'Bienfait 2 — texte', 'default' => 'Noter une petite joie chaque jour aide à voir le beau, même les jours gris.' ),
				'kawami_jr_benefit3_title'  => array( 'type' => 'text', 'label' => 'Bienfait 3 — titre', 'default' => 'Garder une trace' ),
				'kawami_jr_benefit3_text'   => array( 'type' => 'textarea', 'label' => 'Bienfait 3 — texte', 'default' => 'Tes lectures, tes projets, tes envies — tout au même endroit, joliment.' ),
				'kawami_jr_benefit4_title'  => array( 'type' => 'text', 'label' => 'Bienfait 4 — titre', 'default' => 'Un moment pour soi' ),
				'kawami_jr_benefit4_text'   => array( 'type' => 'textarea', 'label' => 'Bienfait 4 — texte', 'default' => "Un rituel doux, sans pression, rien qu'à toi. Du self-care en quelques minutes." ),
				'kawami_jr_premiers_title'  => array( 'type' => 'text', 'label' => '« Les tout premiers » — titre', 'default' => 'Les tout premiers 🌷' ),
				'kawami_jr_premiers_tag'    => array( 'type' => 'text', 'label' => '« Les tout premiers » — étiquette', 'default' => 'disponibles au lancement' ),
				'kawami_jr_premiers_text'   => array( 'type' => 'textarea', 'label' => '« Les tout premiers » — texte', 'default' => 'Deux carnets pour commencer en douceur — en numérique à imprimer, ou en joli carnet papier.' ),
				'kawami_jr_premier1_name'   => array( 'type' => 'text', 'label' => 'Carnet 1 — nom', 'default' => 'Mon Journal de Gratitude' ),
				'kawami_jr_premier1_sous'   => array( 'type' => 'text', 'label' => 'Carnet 1 — sous-titre', 'default' => 'cultiver la gratitude, enrichir chaque jour' ),
				'kawami_jr_premier1_desc'   => array( 'type' => 'textarea', 'label' => 'Carnet 1 — description', 'default' => 'Chaque jour, quelques lignes pour cultiver la douceur : humeur, gratitude et petites victoires, guidé par de tendres illustrations.' ),
				'kawami_jr_premier2_name'   => array( 'type' => 'text', 'label' => 'Carnet 2 — nom', 'default' => 'Journal de mes Lectures' ),
				'kawami_jr_premier2_sous'   => array( 'type' => 'text', 'label' => 'Carnet 2 — sous-titre', 'default' => 'pour les amoureux des livres' ),
				'kawami_jr_premier2_desc'   => array( 'type' => 'textarea', 'label' => 'Carnet 2 — description', 'default' => "Note tes lectures, tes citations préférées, tes avis et ta PAL — un carnet cosy pour garder en mémoire tes meilleurs moments de lecture." ),
				'kawami_jr_avenir_title'    => array( 'type' => 'text', 'label' => '« Et bientôt d\'autres » — titre', 'default' => "Et bientôt d'autres… 💫" ),
				'kawami_jr_avenir_tag'      => array( 'type' => 'text', 'label' => '« Et bientôt d\'autres » — étiquette', 'default' => "en préparation dans l'atelier" ),
				'kawami_jr_avenir1_name'    => array( 'type' => 'text', 'label' => 'À venir 1 — nom', 'default' => "Journal d'anxiété" ),
				'kawami_jr_avenir1_desc'    => array( 'type' => 'textarea', 'label' => 'À venir 1 — description', 'default' => 'Un carnet doux pour accueillir ses émotions, repérer ses déclencheurs et respirer.' ),
				'kawami_jr_avenir2_name'    => array( 'type' => 'text', 'label' => 'À venir 2 — nom', 'default' => 'Journal quotidien — parents occupés' ),
				'kawami_jr_avenir2_desc'    => array( 'type' => 'textarea', 'label' => 'À venir 2 — description', 'default' => 'Un format rapide et bienveillant pour les journées bien remplies, pensé pour les parents.' ),
				'kawami_jr_feature_eyebrow' => array( 'type' => 'text', 'label' => 'Bloc « Numérique & papier » — petit texte', 'default' => '📱 Numérique & 📖 papier' ),
				'kawami_jr_feature_title'   => array( 'type' => 'text', 'label' => 'Bloc « Numérique & papier » — titre', 'default' => 'Sur ta tablette, à imprimer ou en joli livret' ),
				'kawami_jr_feature1_text'   => array( 'type' => 'text', 'label' => 'Numérique & papier — ligne 1', 'default' => 'Version numérique interactive — Notability / GoodNotes' ),
				'kawami_jr_feature2_text'   => array( 'type' => 'text', 'label' => 'Numérique & papier — ligne 2', 'default' => 'Format livret A5 — à imprimer ou en édition papier à couverture rigide' ),
				'kawami_jr_feature3_text'   => array( 'type' => 'text', 'label' => 'Numérique & papier — ligne 3', 'default' => 'Fichier PDF à imprimer — incluant les formats A4 et Lettre (US)' ),
				'kawami_jr_goodies_title'   => array( 'type' => 'text', 'label' => 'Goodies — titre', 'default' => 'À assortir avec des goodies 🪡' ),
				'kawami_jr_goodies_text'    => array( 'type' => 'textarea', 'label' => 'Goodies — texte', 'default' => 'Pour prendre soin de tes carnets et de tes livres, des petits accessoires en tissu fleuri, à venir aussi.' ),
				'kawami_jr_goodie1_name'    => array( 'type' => 'text', 'label' => 'Goodie 1 — nom', 'default' => 'Repère-pages' ),
				'kawami_jr_goodie1_text'    => array( 'type' => 'textarea', 'label' => 'Goodie 1 — texte', 'default' => 'marque-pages en tissu fleuri, cousus main.' ),
				'kawami_jr_goodie2_name'    => array( 'type' => 'text', 'label' => 'Goodie 2 — nom', 'default' => 'Book sleeves' ),
				'kawami_jr_goodie2_text'    => array( 'type' => 'textarea', 'label' => 'Goodie 2 — texte', 'default' => 'housses matelassées pour protéger tes livres.' ),
				'kawami_jr_goodie3_name'    => array( 'type' => 'text', 'label' => 'Goodie 3 — nom', 'default' => 'Marqueurs' ),
				'kawami_jr_goodie3_text'    => array( 'type' => 'textarea', 'label' => 'Goodie 3 — texte', 'default' => 'jolis marqueurs assortis à tes carnets.' ),
				'kawami_jr_nl_title'        => array( 'type' => 'text', 'label' => 'Newsletter — titre', 'default' => 'Sois au courant du lancement' ),
				'kawami_jr_nl_text'         => array( 'type' => 'textarea', 'label' => 'Newsletter — texte', 'default' => "Inscris-toi à la petite lettre de l'atelier : tu sauras dès que les premiers journaux seront disponibles (et tu recevras des pages bonus à imprimer 🎁)." ),
			),
		),
		'kawami_newsletter' => array(
			'title'  => __( 'Accueil — Newsletter', 'kawami' ),
			'fields' => array(
				'kawami_nl_bg_image' => array( 'type' => 'image', 'label' => 'Image de fond' ),
				'kawami_nl_title'    => array( 'type' => 'text', 'label' => 'Titre', 'default' => "La petite lettre de l'atelier" ),
				'kawami_nl_text'     => array( 'type' => 'textarea', 'label' => 'Texte', 'default' => 'Nouveautés, précommandes et retours en convention (promis, pas de spam — juste de la douceur).' ),
			),
		),
	);
}

/**
 * Builds a flat map of every homepage/page field id -> its declared
 * 'default' value, from kawami_homepage_fields()'s nested sections.
 */
function kawami_field_defaults() {
	static $defaults = null;
	if ( null === $defaults ) {
		$defaults = array();
		foreach ( kawami_homepage_fields() as $section ) {
			foreach ( $section['fields'] as $id => $field ) {
				$defaults[ $id ] = $field['default'] ?? '';
			}
		}
	}
	return $defaults;
}

/**
 * Shorthand: get a homepage Customizer field's current value (falls back
 * to its declared default from kawami_homepage_fields()).
 */
function kawami_field( $id ) {
	$defaults = kawami_field_defaults();
	return get_theme_mod( $id, $defaults[ $id ] ?? '' );
}

/**
 * Shorthand: get a homepage image field's URL (Customizer image controls
 * store the attachment URL directly as the theme_mod value).
 */
function kawami_field_image( $id, $size = 'full' ) {
	$value = get_theme_mod( $id, '' );
	if ( ! $value ) {
		return '';
	}
	$attachment_id = attachment_url_to_postid( $value );
	if ( $attachment_id ) {
		$src = wp_get_attachment_image_src( $attachment_id, $size );
		if ( $src ) {
			return $src[0];
		}
	}
	return $value;
}

/**
 * WooCommerce layout hooks: Kawami markup replaces most default wrappers
 * (see woocommerce/ template overrides), but we still remove a few
 * default hooks that don't fit the design and aren't overridden by a
 * template file.
 */
function kawami_woocommerce_setup() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
}
add_action( 'init', 'kawami_woocommerce_setup' );

/**
 * "Produits similaires" was fought over several rounds without a working
 * fix (its grid layout wouldn't cooperate). Disabled outright for now -
 * remove this line to bring it back once someone can debug it live.
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/**
 * Hide the SKU (UGS) from product pages - it's an internal reference
 * (auto-generated from the product name during the catalogue import),
 * not something customers need to see. Categories/tags stay visible.
 */
add_filter( 'wc_product_sku_enabled', '__return_false' );

/**
 * Returns the permalink for a nav page picked in the Customizer
 * (kawami_page_accessoires, kawami_page_journaux, kawami_page_apropos,
 * kawami_page_contact), or empty string if not set/published.
 */
function kawami_nav_page_url( $theme_mod_key ) {
	$page_id = absint( get_theme_mod( $theme_mod_key, 0 ) );
	if ( ! $page_id || get_post_status( $page_id ) !== 'publish' ) {
		return '';
	}
	return get_permalink( $page_id );
}

/**
 * Cart count bubble helper used in header.php.
 */
function kawami_cart_count() {
	if ( ! class_exists( 'WooCommerce' ) || is_admin() ) {
		return 0;
	}
	return WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
}

/**
 * Newsletter signup handler (front-page.php form) - no 3rd-party email
 * service required. Stores each address as a 'kawami_lead' post so it
 * shows up as a simple list in wp-admin; wire a real ESP (Brevo,
 * Mailchimp...) later by hooking into 'kawami_newsletter_signup' below.
 */
function kawami_register_lead_cpt() {
	register_post_type( 'kawami_lead', array(
		'label'        => __( 'Newsletter', 'kawami' ),
		'public'       => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-email',
		'supports'     => array( 'title' ),
	) );
}
add_action( 'init', 'kawami_register_lead_cpt' );

function kawami_handle_newsletter_signup() {
	if ( ! isset( $_POST['kawami_newsletter_nonce'] ) || ! wp_verify_nonce( $_POST['kawami_newsletter_nonce'], 'kawami_newsletter_signup' ) ) {
		wp_die( esc_html__( 'Requête invalide.', 'kawami' ) );
	}

	$email = isset( $_POST['kawami_email'] ) ? sanitize_email( wp_unslash( $_POST['kawami_email'] ) ) : '';

	if ( $email && is_email( $email ) ) {
		$existing = get_page_by_title( $email, OBJECT, 'kawami_lead' );
		if ( ! $existing ) {
			wp_insert_post( array(
				'post_type'   => 'kawami_lead',
				'post_title'  => $email,
				'post_status' => 'publish',
			) );
		}
		/**
		 * Fires after a newsletter signup is stored - hook a real email
		 * service provider here (Brevo, Mailchimp, etc).
		 */
		do_action( 'kawami_newsletter_signup', $email );
	}

	$redirect = wp_get_referer() ?: home_url( '/' );
	wp_safe_redirect( add_query_arg( 'kawami_newsletter', 'ok', $redirect ) . '#newsletter' );
	exit;
}
add_action( 'admin_post_kawami_newsletter_signup', 'kawami_handle_newsletter_signup' );
add_action( 'admin_post_nopriv_kawami_newsletter_signup', 'kawami_handle_newsletter_signup' );

/**
 * Single product page extras: availability badge before the title, a
 * small "care info" list + shipping/preorder/safety accordion after the
 * short description. Mirrors the Shopify kawami-product.liquid content
 * that isn't native to WooCommerce's own summary hooks.
 */
function kawami_product_availability_badge() {
	global $product;
	echo '<div class="kawami-availability-badge">' . kawami_availability_badge( $product, '' ) . '</div>'; // phpcs:ignore
}
add_action( 'woocommerce_single_product_summary', 'kawami_product_availability_badge', 4 );

function kawami_product_care_info() {
	?>
	<div style="background: #fff7e8; border: 1.5px solid #f0dcb8; border-radius: 16px; padding: 14px 18px; margin: 0 0 18px; font: 600 13px/1.6 var(--k-font-ui); color: var(--k-beige-darker)">
		<strong><?php echo esc_html( kawami_field( 'kawami_pp_care_banner' ) ); ?></strong>
	</div>
	<div class="kawami-care-list">
		<div><span class="icon">🌿</span><?php echo esc_html( kawami_field( 'kawami_pp_care1' ) ); ?></div>
		<div><span class="icon">🫧</span><?php echo esc_html( kawami_field( 'kawami_pp_care2' ) ); ?></div>
		<div><span class="icon">🎀</span><?php echo esc_html( kawami_field( 'kawami_pp_care3' ) ); ?></div>
	</div>
	<?php
}
// Before the add-to-cart form (priority 30), so the buy button stays close
// to the price instead of being buried under extra info blocks.
add_action( 'woocommerce_single_product_summary', 'kawami_product_care_info', 25 );

function kawami_product_accordion() {
	$delay        = esc_html( get_theme_mod( 'kawami_preorder_delay_text', '2-3 semaines' ) );
	$preorder_text = str_replace( '{delai}', $delay, kawami_field( 'kawami_pp_preorder_text' ) );
	?>
	<details class="k-accordion-item" open>
		<summary class="k-accordion-item__head"><?php echo esc_html( kawami_field( 'kawami_pp_shipping_title' ) ); ?></summary>
		<div class="k-accordion-item__body"><?php echo esc_html( kawami_field( 'kawami_pp_shipping_text' ) ); ?></div>
	</details>
	<details class="k-accordion-item">
		<summary class="k-accordion-item__head"><?php echo esc_html( kawami_field( 'kawami_pp_preorder_title' ) ); ?></summary>
		<div class="k-accordion-item__body"><?php echo esc_html( $preorder_text ); ?></div>
	</details>
	<details class="k-accordion-item">
		<summary class="k-accordion-item__head"><?php echo esc_html( kawami_field( 'kawami_pp_safety_title' ) ); ?></summary>
		<div class="k-accordion-item__body"><?php echo esc_html( kawami_field( 'kawami_pp_safety_text' ) ); ?></div>
	</details>
	<?php
}
// After the add-to-cart form (priority 30) and before product meta (40).
add_action( 'woocommerce_single_product_summary', 'kawami_product_accordion', 35 );

/**
 * Contact page form handler: sends a plain wp_mail() to the site admin
 * email - no 3rd-party form plugin required. Swap kawami_contact_notify()
 * later for a real ESP/CRM integration if needed.
 */
function kawami_handle_contact_form() {
	if ( ! isset( $_POST['kawami_contact_nonce'] ) || ! wp_verify_nonce( $_POST['kawami_contact_nonce'], 'kawami_contact_form' ) ) {
		wp_die( esc_html__( 'Requête invalide.', 'kawami' ) );
	}

	$name    = isset( $_POST['kawami_name'] ) ? sanitize_text_field( wp_unslash( $_POST['kawami_name'] ) ) : '';
	$email   = isset( $_POST['kawami_email'] ) ? sanitize_email( wp_unslash( $_POST['kawami_email'] ) ) : '';
	$subject = isset( $_POST['kawami_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['kawami_subject'] ) ) : 'Une question';
	$message = isset( $_POST['kawami_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['kawami_message'] ) ) : '';

	$sent = false;
	if ( $email && is_email( $email ) && $message ) {
		$to      = get_theme_mod( 'kawami_contact_email', get_option( 'admin_email' ) );
		$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . ( $name ? "$name <$email>" : $email ) );
		$body    = "De : {$name} <{$email}>\nSujet : {$subject}\n\n{$message}";
		$sent    = wp_mail( $to, '[Kawami] ' . $subject, $body, $headers );
		do_action( 'kawami_contact_form_submitted', $name, $email, $subject, $message );
	}

	$redirect = wp_get_referer() ?: home_url( '/' );
	wp_safe_redirect( add_query_arg( 'kawami_contact', $sent ? 'ok' : 'error', $redirect ) );
	exit;
}
add_action( 'admin_post_kawami_contact_form', 'kawami_handle_contact_form' );
add_action( 'admin_post_nopriv_kawami_contact_form', 'kawami_handle_contact_form' );
