# Kawami — Shopify theme

A custom Shopify Online Store 2.0 theme for **Kawami**, a French artisan brand
selling handmade crochet plushies, sewn accessories, and printable/paper
journals. Built from the design references in `design_handoff_kawami/` (the
`.dc.html` files are the visual source of truth — see
`design_handoff_kawami/README.md` for the original brief).

## What's here

`theme/` is an installable Shopify theme (Liquid + JSON templates, Online
Store 2.0 style — sections, blocks, schema settings editable in the theme
editor). It is **not** a fork of Shopify's Horizon/Dawn source — it's a
lean, purpose-built theme matching Kawami's exact design tokens (Sakura
color palette, Zen Maru Gothic / Quicksand / Cormorant Garamond type,
marquee/hero animations), using Shopify's native objects for everything
transactional (cart, checkout, product, collection, customer, forms).

### Pages implemented
- **Accueil** (`index.json`) — announcement bar, hero, "Mes univers",
  featured products, custom-order CTA, atelier couture teaser, story
  teaser, Instagram grid, newsletter.
- **Boutique** (`collection.json`) — tag-filtered product grid, native
  pagination.
- **Fiche produit** (`product.json`) — gallery, variant picker (JS-driven,
  no framework), price/compare-at, quantity, add-to-cart, accordions
  (shipping, made-to-order, safety), related products.
- **Accessoires** (`page.accessoires.json`) — "coming soon" page.
- **Journaux — Esprits Divergents** (`page.journaux.json`) — digital (PDF)
  + paper journal cards, editable via repeatable blocks in the theme
  editor; each block can optionally link to a real product/variant.
- **Mon histoire** (`page.a-propos.json`) — Savie's story, Willow card,
  values, convention note.
- **Contact** (`page.contact.json`) — Shopify's native contact form.
- **Panier** (`cart.json`) — native cart object, free-shipping threshold,
  mixed stock/preorder note.
- **Mon compte** — this store uses Shopify's **new hosted customer
  accounts** (confirmed: no Classic/New toggle exists in Settings →
  Customer accounts, so this can't be switched back). That hosted flow
  lives entirely on `shopify.com`, outside the theme, so it can't be
  restyled from code at all — not a bug, a Shopify platform limitation
  for this store. The theme previously shipped classic
  `customers/*.liquid` templates for this; removed, since they can never
  render here. For at least some brand consistency (logo/colors/font on
  that hosted page), use Shopify admin → Settings → Checkout →
  Personnaliser (checkout and new customer-accounts share one branding
  editor).

Standard fallback templates (404, search, blog, article, list-collections,
gift card, password page) are included so the theme is fully installable,
even though they weren't part of the original 8-screen design brief.

## First-time setup after uploading the theme

**See `SETUP.md`** — a theme zip only contains code; the Journaux,
Accessoires, Mon histoire, and Contact pages need to be created once as
actual Shopify Pages (with the matching template assigned) before they'll
appear anywhere, and the header/footer need those pages picked in the
theme editor. This is normal Shopify behavior, not specific to this
theme, but it trips people up on the first install.

## Brand settings

Colors, the free-shipping threshold, and preorder delay text are exposed
in **Theme settings** so the merchant can tweak them without touching
code. Navigation (which collection/pages the header "Boutique" dropdown
and footer point to) is configured per-section in the theme editor.

## Installing on Shopify

```
cd theme
shopify theme push --store your-store.myshopify.com
```

or zip the `theme/` folder's contents (not the folder itself) and upload
via **Online Store → Themes → Add theme → Upload zip file**.

## Availability badge (En stock / Précommande / Épuisé)

Computed automatically (`snippets/kawami-availability-badge.liquid`) — no
tagging needed for the normal case:
- **En stock** — purchasable, tracked inventory > 0.
- **Précommande** — Shopify still lets customers buy it despite zero
  tracked inventory. This is exactly what **"Continue selling when out of
  stock"** (Shopify admin → product → Inventory) produces: turn that on
  for a made-to-order item and the badge switches to Précommande on its
  own, everywhere (collection grid, featured products, cart, product
  page), replacing what would otherwise show as Épuisé.
- **Épuisé** — not purchasable at all (zero inventory, continue-selling
  off).

Tag a product **`precommande`** to force the badge regardless of
inventory state (e.g. you want it to read Précommande before you've
touched inventory settings yet).

## Scope notes

- Fonts are loaded via Google Fonts (matching the design exactly) rather
  than Shopify's font picker, since the brief's exact families aren't in
  Shopify's curated list.
- Multi-language/multi-currency should be configured via **Shopify
  Markets** + **Translate & Adapt** in the admin, per the original brief —
  the demo `i18n.js`/`translations.js` in the design package are reference
  only and aren't wired into the theme.
- `produits.js` (~56 demo products) is reference only; real catalog data
  lives in the merchant's Shopify product admin.
