# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A Netivo WordPress module (Composer package `netivo/wc-widget-filters`) that adds a product filters widget
for WooCommerce (category, availability, promotion, attribute, and price filters) plus an admin settings
page for configuring which attribute filters show per category. It is installed as a dependency into a
Netivo theme built on top of `netivo/wp-core` and `netivo/woocommerce` — it is not a standalone WordPress
site and cannot be run/booted by itself.

## Commands

PHP (Composer):
- `composer install` — install PHP dependencies (`netivo/wp-core`, `netivo/woocommerce`, requires PHP >=8.1)

JS/CSS (via `@netivo/scripts`, delegated through npm scripts):
- `npm run develop` — build sources with a watcher for local development
- `npm run build` — production build of JS/CSS into `dist/`
- `npm run lint` — lint JS and SCSS sources

There is no test suite in this repository.

## Architecture

**Entry point (`src/Module.php`)** wires everything together and is expected to be instantiated by the
consuming theme. On construction it:
- Registers the admin settings page (`Admin\Page\Filters`) only when `is_admin()`.
- Hooks `wc_get_template` to redirect WooCommerce's template loader to this module's own templates
  (`views/templates/widget/*.php`) whenever the theme doesn't already override them — this is how the
  widget's HTML can be themed by consuming projects while still having sane defaults.
- Enqueues the compiled `dist/netivo-woocommerce-filters.css` and `.js` on the frontend.
- Registers the `Widget\Filters` WP_Widget on `widgets_init`.
- Instantiates `Archive`, which hooks `posts_clauses` to apply the `filter_availability` query param
  (in-stock / out-of-stock) to the main product query via a join against `wp_wc_product_meta_lookup`.

**Widget (`src/Widget/Filters.php`)** is a classic `WP_Widget`. Each filter type (category, availability,
promotion, attributes, price) is a `print_*_filter()` method that builds a data array and calls
`wc_get_template('widget/filters-*.php', [...])` — the actual markup lives in
`views/templates/widget/*.php`, not in the PHP class. Key things to know when touching this class:
- Filter state is read/written entirely through query string args (`filter_availability`,
  `filter_promotion`, `filter_<attribute>`, `min_price`/`max_price`, WooCommerce's own layered-nav
  `query_type_*` args) — there is no JS-side state beyond checkbox aggregation
  (`sources/javascript/attributeFilter.js`) and hidden-filter toggling
  (`sources/javascript/hiddenFilters.js`). Any new filter type should follow the same "build a link with
  the toggled query arg" pattern seen in `print_availability_filter`/`print_promotion_filter`.
- Attribute filter visibility per category is controlled by the `_nt_filters` option (an array keyed by
  category term_id, or `'search'` for the search results context), maintained by the admin page.
  `print_attributes_filter` falls back from the current category to its parent category, then to the
  `search` key.
  - Term counts for attribute filters use WooCommerce's internal
    `Automattic\WooCommerce\Internal\ProductAttributesLookup\Filterer` service from the WC container.
  - Category term counts (`get_term_count`) are computed with a hand-rolled SQL query (not `WP_Term_Query`
    counts) so they can be scoped to the current search/query context.
- Optional integration: if the sibling module `Netivo\Module\WooCommerce\AlternateCategories` is loaded,
  category filter links/names are rewritten to an alternate "category + manufacturer" tree via
  `apply_filters('netivo/widget/filters/alternate-tree', ...)` and
  `Product::replace_home_with_manufacturer()`. Don't assume that module is present — everything here is
  guarded by `class_exists(...)`.
- Widget instance options: `filters` (array of enabled filter keys), `form` (submit-button mode vs.
  instant-apply links), `always_show` (render outside shop/category/tax archive contexts too).

**Admin page (`src/Admin/Page/Filters.php`)** extends `Netivo\Core\Admin\Page` from `netivo/wp-core`
(`vendor/netivo/wp-core/src/Core/Admin/Page.php`). That base class handles menu registration, view
resolution (via the `#[\Netivo\Attributes\View('filters')]` attribute → `views/admin/pages/filters.phtml`),
and the save lifecycle (`do_save()` calls `save()` when the form for the *current* `_menu_slug` was
posted). Subclasses only need to implement `do_action()` (prepare `$this->view` data) and `save()`
(persist `$_POST` into options) — see `Filters::save()`, which writes per-category attribute selections
into the `_nt_filters` option keyed by `$_GET['nt_cat']`.

**`Archive` class (`src/Archive.php`)** is intentionally separate from the widget/admin classes — it's
the only piece that mutates the main WP query (`posts_clauses`), so it's easy to find when debugging
availability-filter query behavior independent of widget rendering.

**Template override chain**: `views/templates/widget/*.php` are the default templates;
`Module::change_template_path()` only falls back to them `if (!file_exists($template))`, meaning a theme
can override any single filter template by placing a matching `widget/filters-*.php` file in its own
WooCommerce template path — check there first when a filter's markup looks unexpected.

**Frontend assets** live in `sources/` (entry points under `sources/javascript/entries/` and
`sources/sass/entries/`) and are compiled by `@netivo/scripts` (a private Netivo webpack wrapper) into
`dist/`, which is what `Module::add_assets_to_page()` actually enqueues. Edit `sources/`, never `dist/`
directly — `dist/` is build output (though it is currently committed to the repo).

## Extension points (WordPress filters this module fires)

- `netivo/widget/filters/categories` — filter the final category filter array before rendering.
- `netivo/widget/filters/parent` — filter the "back to parent category" link array (`id`, `link`,
  `name`, or `null` when there is no parent) before rendering; fires after the alternate-tree block
  like `categories` does, so external filters see the final manufacturer-aware value.
- `netivo/widget/filters/alternate-tree` — toggle whether the alternate category/manufacturer tree logic
  applies (defaults to whether the AlternateCategories module is active).
- `netivo/widget/filters/availability-options` — filter the availability filter options array.
- `netivo/widget/filters/availability-clauses` — fired (not filtered) after the `posts_clauses` mutation
  in `Archive::availability_filter`, useful as a hook point rather than a value filter.
- `netivo_filters_category_title` — filter the category section heading text in the template.

## Conventions

- All PHP files must start with the `ABSPATH` guard (`if (!defined('ABSPATH')) { header(...); exit; }`),
  matching the rest of the Netivo module ecosystem.
- Namespace root is `Netivo\Module\WooCommerce\Filters`, mapped from `src/` via PSR-4.
- User-facing strings use the `netivo` text domain and are largely in Polish (this targets Polish-market
  WooCommerce stores) — keep new strings consistent with that.
- Query-string filter params intentionally shadow WooCommerce's own layered nav conventions
  (`filter_<attribute>`, `query_type_<attribute>`) so this widget's filters compose with WooCommerce core
  filtering rather than replacing it.
