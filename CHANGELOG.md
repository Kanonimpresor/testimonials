# Changelog

All notable changes to the Testimonials plugin are documented in this file.

---

## [Unreleased] — Roadmap v4.1.0+

> Planned improvements for future releases. Items marked with 🎯 are priority.

### 🎯 1. SEO — No-Index Option for Submit Page
- Add admin preference `tm_noindex` (boolean) to inject `<meta name="robots" content="noindex, nofollow">` on the submit form page (`testimonials.php`).
- Prevents search engines from indexing the submission form, which has no public value for SEO.
- Implementation: add meta tag in `testimonials.php` before `require_once(HEADERF)` using `e107::meta()`.

### 🎯 2. Menu Display Mode — Template Selector
Add a new admin tab **"Display"** with a dropdown to choose menu rendering mode:
- **a) Carousel (current)** — Single-slide BS5 carousel with indicators and prev/next controls.
- **b) Cards Carousel** — Infinite-scroll multi-card carousel (3 visible cards at once) using CSS scroll-snap or tiny-slider. Each card shows author avatar, name, message excerpt, and star rating. Ideal for placing in content areas via e107 Menu Manager.
- Implementation:
  - New admin pref `tm_display_mode` (`carousel` | `cards`).
  - New template keys `menu_cards_header`, `menu_cards_body`, `menu_cards_footer`.
  - New CSS section for `.testimonials-cards-carousel`.
  - `testimonials_menu.php` selects template based on pref.

### 3. Star Rating System
- Add `tm_rating` column (TINYINT, 1-5) to the database.
- Show star icons (FontAwesome `fa-star`) in the carousel and cards templates.
- Allow users to set rating on the submit form (interactive star picker).
- Display average rating in admin list.
- New admin field for `tm_rating` with validation (1-5).
- DB migration in `testimonials_setup.php` `upgrade_post()`.

### 4. Admin Enhancements
- **Bulk Actions**: Enable batch approve/block for pending testimonials.
- **Datestamp Column**: Show formatted date in admin list (`tm_datestamp` as readable date).
- **Filter by Status**: Quick filter tabs for "All", "Active", "Pending Approval".
- **Preview**: Live preview of how the testimonial will appear in the carousel.
- **Export**: CSV export of testimonials for backup.

### 5. Avatar Support
- Display user avatar (from e107 user profile) next to the testimonial author name.
- Fallback to initials-based avatar (CSS generated) for anonymous users (UID=0).
- New shortcode `{TESTIMONIALS_AVATAR}` in templates.

### 6. GDPR / Privacy Compliance
- Add GDPR consent checkbox on the submit form (`tm_gdpr_consent`).
- New admin preference `tm_gdpr_enabled` (boolean).
- Store consent timestamp in a new column `tm_consent_date`.
- Add privacy policy link configurable from admin.
- New LAN constants for GDPR text.

### 7. Notification System
- Email notification to admin when a new testimonial is submitted.
- Use e107 `e_notify.php` handler for integration with the notification system.
- Optional: email confirmation to submitter when testimonial is approved.

### 8. Testimonial Categories / Tags
- Add `tm_category` column for grouping testimonials.
- Admin management of categories.
- Shortcode filter to display only specific categories in different menu placements.
- Enables multiple carousel instances on different pages with different content.

### 9. Rich Content & Media
- Support for author photo upload (not just avatar from user profile).
- Optional company/organization field (`tm_company`).
- Optional role/position field (`tm_role`).
- Renders as: _"Great service!" — **John Doe**, CEO at Company_

### 10. Performance & Caching
- Implement e107 cache for menu rendering (`e107::getCache()`).
- Cache key based on testimonial count + last modified timestamp.
- Automatic cache invalidation on admin CRUD operations.
- Reduce DB queries on high-traffic pages.

### 11. Structured Data (Schema.org)
- Output JSON-LD `Review` / `Testimonial` schema on pages with testimonials.
- Improves SEO with rich snippets in search results.
- Admin toggle `tm_schema_enabled` to enable/disable.

### 12. Import / Seed Data
- Admin option to import testimonials from CSV.
- Demo/seed data button to populate with sample testimonials for new installations.
- Useful for theme demos and development environments.

### 13. Security Hardening
- Rate limiting on submit form (prevent spam floods).
- Honeypot hidden field as additional anti-spam layer.
- XSS sanitization review on all output shortcodes.
- CSRF token validation on form submission.

### 14. Accessibility Improvements
- `aria-live="polite"` region for dynamic carousel content changes.
- Pause carousel on hover/focus for screen reader users.
- High contrast mode support in CSS.
- Reduced motion support (`prefers-reduced-motion` media query).

### 15. Database Modernization
- Change engine from `MyISAM` to `InnoDB` for better integrity and performance.
- Add `tm_updated` timestamp column for edit tracking.
- Fix typo in SQL comment: `anme` → `name`.
- Consider `utf8mb4` charset for full emoji support.

---

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
