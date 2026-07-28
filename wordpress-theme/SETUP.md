# Kawami — thème WooCommerce (Hostinger) — mise en route

Ce dossier (`wordpress-theme/kawami/`) est un thème WordPress/WooCommerce
sur-mesure qui reproduit le design Sakura du site Shopify (`theme/`, qui
reste inchangé et indépendant).

## 1. Préalables

1. Hébergement Hostinger avec **WordPress** installé (via l'installeur en
   1 clic de Hostinger — ne pas utiliser "Migrer un site existant",
   Shopify n'est pas compatible avec cet outil).
2. Extension **WooCommerce** installée et activée (Extensions → Ajouter →
   rechercher « WooCommerce »).
3. Suivre l'assistant de configuration WooCommerce (devise, adresse de la
   boutique, moyen de paiement — Stripe ou PayPal recommandés).

## 2. Installer le thème

1. Compresse le dossier `kawami/` en `kawami.zip` (le dossier `kawami`
   doit être à la racine du zip, pas un sous-dossier).
2. Dans l'admin WordPress : Apparence → Thèmes → Ajouter → Téléverser un
   thème → sélectionne `kawami.zip` → Installer → **Activer**.
3. Apparence → Personnaliser → un menu **« Réglages Kawami »** et
   plusieurs sections « Accueil — ... » / « Page — ... » apparaissent :
   c'est là que se remplissent tous les textes/images éditables (hero,
   mon histoire, contact, etc.), comme les réglages de section sur
   Shopify.

## 3. Créer les pages

WordPress choisit automatiquement le bon design selon le **slug** (l'URL)
de la page — crée une page (Pages → Ajouter) avec exactement ces slugs :

| Page à créer | Slug (URL) |
|---|---|
| Mon histoire | `mon-histoire` |
| Contact | `contact` |
| Accessoires | `accessoires` |
| Journaux | `journaux` |

Le contenu de la page elle-même (le corps de texte WordPress) peut rester
vide — tout l'affichage vient du thème. Une fois créées, va dans
Personnaliser → « Réglages Kawami » pour relier ces pages au menu
(Accessoires / Journaux / Mon histoire / Contact) et à l'email de
contact.

La page d'accueil se configure dans Réglages → Lecture → « Une page
statique » → Page d'accueil = n'importe laquelle (le thème utilise
`front-page.php` automatiquement, peu importe la page choisie).

## 4. Produits

- Chaque produit WooCommerce a son badge automatique :
  - **En stock** par défaut
  - **Précommande** si le produit a le tag `precommande` (Produits →
    Étiquettes), ou si le suivi de stock est activé avec 0 en stock et
    "Autoriser les commandes en attente de réapprovisionnement" activé
  - **Épuisé** si le produit est marqué en rupture de stock
- La section **« Mes univers »** de l'accueil affiche automatiquement les
  5 premières catégories de produits — ajoute une image à chaque
  catégorie (Produits → Catégories → modifier → Image) pour qu'elle
  apparaisse joliment en rond.

## 5. Ce qui est simplifié par rapport à Shopify (pour rester livrable maintenant)

- **Pas de sélecteur de devise multi-marché natif** : WooCommerce gère
  une seule devise par défaut. Pour plusieurs devises, il faudra une
  extension dédiée plus tard (ex: WOOCS).
- **Newsletter et formulaire de contact** : fonctionnent déjà (email
  envoyé via `wp_mail`, inscriptions stockées dans un menu « Newsletter »
  du tableau de bord) mais sans service d'emailing externe (Mailchimp/
  Brevo). Un point d'accroche (`do_action`) existe dans `functions.php`
  pour brancher un vrai ESP plus tard.
- **Grille Instagram** : affichage statique (pas de connexion à l'API
  Instagram) — remplace les blocs vides dans `front-page.php` par de
  vraies images si besoin.
- **Textes des pages "Mon histoire" / bandeaux d'annonce / étapes
  commande perso** : codés en dur dans les fichiers PHP plutôt
  qu'éditables depuis le Customizer (moins de champs à gérer pour
  livrer plus vite) — modifiables directement dans les fichiers
  `page-mon-histoire.php`, `header.php`, `front-page.php`.

## 6. Déploiement

Une fois WordPress/WooCommerce en place, donne un accès SFTP/SSH (ou
WP-admin) pour que le thème soit déployé et testé directement.
