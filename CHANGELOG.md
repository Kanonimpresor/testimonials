# Changelog

All notable changes to the Testimonials plugin are documented in this file.

## [4.0.0] — 2026-03-07

### Added
- Bootstrap 5.3 carousel with indicators, prev/next controls, and auto-slide.
- Front-end submit form with modern BS5 layout and Royal Bus palette.
- Captcha support (e107 secure image) on submit form with `renderImage()` + `renderInput()`.
- Admin "Create" option for adding testimonials directly from the admin panel.
- Auto-fill `tm_datestamp` and `tm_name` (UID.Name format) on admin create.
- SEF URL support with editable alias via e107 URL manager (`e_url.php` with `alias` field).
- Site link auto-registration via `plugin.xml` `<siteLinks>`.
- Conditional CSS/JS loading — assets only load when menu is active or on testimonials page.
- Portuguese language pack (frontend, admin, global).
- New LAN constants: `LAN_TESTIMONIALS_12` to `LAN_TESTIMONIALS_19` (captcha, login, carousel nav, read more/less).
- New LAN constants: `LAN_TESTIMONIALS_ADMIN_18`, `LAN_TESTIMONIALS_ADMIN_19` (admin field placeholder/help).
- `data-readmore` / `data-readless` attributes on carousel section for i18n in JavaScript.
- Keyboard-accessible "Read more / Read less" toggle with dynamic ARIA labels.
- Access denied page with lock icon and login button for non-authenticated users.
- `README.md` with full documentation.
- `CHANGELOG.md`.

### Changed
- Migrated all templates from Bootstrap 3 to Bootstrap 5.3 (carousel, form, buttons).
- Replaced Glyphicons with FontAwesome 5 icons throughout.
- Replaced all hardcoded strings with LAN constants (frontend, admin, JS).
- Improved Spanish translations (corrected grammar, added missing constants).
- Updated `English_global.php` with descriptive `SUMM` and `DESC` values.
- CSS modernized with Royal Bus palette (`#FFDC00`, `#1D1D1D`, `#b8a000`).
- Submit button uses `.btn-royal-yellow` with hover/focus state transitions.
- Captcha wrapper styled with background, border-radius, and flex layout.
- Removed `max-width` restriction on submit form wrapper for Full Page layout compatibility.
- Carousel `max-width` increased to `960px` for Full Page layout.

### Fixed
- Admin white screen caused by `beforeCreate()` signature incompatibility with PHP 8.2.
- Carousel indicators not rendering — root cause: `setVars()` in loop overwrote `count` variable.
- Carousel navigation (prev/next) not working due to empty indicators in BS5.
- `$totalItems` preserved and restored via `setVars()` before footer template parse.
- Removed broken cache mechanism from menu renderer.

### Removed
- Bootstrap 3 markup (panels, glyphicons, `data-ride`, `data-slide`).
- Beerpay donation badge from README.
- Legacy cache handling in `testimonials_menu.php`.

## [3.0] — 2015-03-25

### Original Release
- Original plugin by [lonalore](http://lonalore.hu).
- Bootstrap 3 carousel with glyphicon navigation.
- Basic admin panel with e107 Admin UI.
- Front-end submit form.
- English and Spanish language packs.
- Database migration from v2.x format.
