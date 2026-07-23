# Kawami — mise en place après l'upload du thème

Un thème (le zip) contient uniquement du **code** (templates, sections,
styles). Il ne peut pas créer tout seul les **Pages** ou la **Collection**
de ta boutique — ça, c'est du contenu, et Shopify t'oblige à le créer une
fois, à la main, dans l'admin. Voici la liste exacte à faire, dans l'ordre.

## 1. Crée les 4 pages

Va dans **Boutique en ligne → Pages → Ajouter une page**. Pour chacune :
1. Mets le titre indiqué ci-dessous.
2. **Laisse le contenu (corps de la page) vide** — ne colle rien dedans,
   tout l'affichage vient du template, pas du corps de texte. (Si tu as
   déjà collé du contenu dans une page — ex. « Mon-histoire » — efface-le
   complètement et enregistre.)
3. Dans la colonne de droite, sous **Modèle de thème**, choisis le modèle
   indiqué.
4. Enregistre.

| Titre de la page   | Modèle de thème à choisir |
|---------------------|----------------------------|
| Mon histoire         | `page.a-propos`            |
| Contact               | `page.contact`             |
| Journaux              | `page.journaux`            |
| Accessoires           | `page.accessoires`         |

Le menu déroulant « Modèle de thème » ne liste ces options qu'**après**
que le thème avec ces fichiers soit uploadé — si tu ne les vois pas,
réuploade la dernière version du zip d'abord.

## 2. La collection « Boutique »

Le champ **Collection « Boutique »** dans les réglages de l'en-tête est
optionnel — si tu ne choisis rien, le lien "Boutique" pointe
automatiquement vers **Toutes les peluches** (`/collections/all`), donc
tu peux l'ignorer pour l'instant.

Si tu préfères choisir une collection précise (par exemple pour n'afficher
que certains produits) :
1. **Produits → Collections → Créer une collection**, donne-lui un titre
   (ex. « Peluches »), choisis les produits à inclure, enregistre.
2. Reviens dans le thème (Personnaliser → En-tête Kawami) et clique sur
   le texte **« Sélectionner »** du champ Collection (pas la petite icône
   base de données à côté — celle-là sert à connecter un champ meta, pas
   à choisir une collection normale).

## 3. Relier les pages dans l'en-tête et le pied de page

Toujours dans **Personnaliser** :
- Clique sur la section **« En-tête Kawami »** → renseigne "Page
  «Accessoires»", "Page «Journaux»", "Page «Mon histoire»", "Page
  «Contact»" avec les pages créées à l'étape 1.
- Clique sur la section **« Pied de page Kawami »** → même chose pour
  "Page «Mon histoire»" et "Page «Contact»".
- Enregistre.

## 4. Comptes clients (Mon compte)

Si "Mon compte" plantait, c'est que ta boutique utilise les **comptes
clients classiques** (pas les nouveaux comptes hébergés par Shopify). Le
thème inclut maintenant les bons templates (`customers/login.liquid`,
`account.liquid`, etc.) — reuploade le zip et la page devrait s'afficher
normalement, connectée ou non.

## 5. Images de marque

Le logo, la photo héro des Journaux, les photos de l'accueil, etc. sont
des champs `image_picker` vides par défaut (normal pour un thème neuf) —
ajoute-les toi-même via **Personnaliser** → clique sur chaque section →
uploade tes images.
