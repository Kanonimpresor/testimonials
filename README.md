# Testimonials Plugin for e107

#### (Elija su idioma abajo / Choose your language below / Escolha o seu idioma abaixo)

[![Language-English](https://img.shields.io/badge/Language-English-blue)](README.md) 
[![Language-Português](https://img.shields.io/badge/Language-Português-green)](README.pt-PT.md) 
[![Language-Español](https://img.shields.io/badge/Language-Español-red)](README.es-ES.md) 

A modern testimonials plugin for **e107 v2.x** that displays customer testimonials in a Bootstrap 5 carousel and provides a front-end submission form.

## Features

- **Bootstrap 5 Carousel** — Responsive testimonial slider with indicators and navigation controls.
- **Front-end Submit Form** — Authenticated users can submit testimonials directly from the website.
- **Captcha Support** — Optional e107 secure image captcha on the submit form.
- **Approval Workflow** — Submitted testimonials can require admin approval before publishing.
- **Admin Panel** — Full CRUD management via e107 Admin UI (list, create, edit, delete, reorder).
- **Text Truncation** — Configurable message length trimming with interactive "Read more / Read less" toggle.
- **SEF URLs** — Clean URL support with editable alias via e107 URL manager.
- **Multi-language** — Full i18n support with English, Spanish, and Portuguese translations.
- **Accessible** — ARIA labels, keyboard navigation, and screen reader support.

## Requirements

- e107 v2.3.1 or higher
- PHP 8.0 or higher
- Bootstrap 5.x (loaded by e107 or theme)
- FontAwesome 5.x (loaded by e107 or theme)

## Installation

1. Upload the `testimonials` folder to `e107_plugins/`.
2. Go to **Admin > Plugin Manager** and install the plugin.
3. Go to **Admin > Menus** and place `testimonials_menu` in a menu area on your desired page(s).
4. Configure the plugin in **Admin > Testimonials**.

## Configuration

Navigate to **Admin > Testimonials > Settings**:

| Setting | Description | Default |
|---------|-------------|---------|
| Number of items in the menu | How many testimonials to display in the carousel | 3 |
| Trim messages to a maximum length | Character limit for displayed messages (0 = no trim) | 250 |
| User class can submit | Which user class can access the submit form | Members |
| Use captcha on submit form | Enable/disable captcha verification | Yes |
| Approval is required? | Require admin approval for new submissions | Yes |

## URL Configuration

The plugin registers a SEF URL route. You can customize the URL alias in:

**Admin > Settings > URL Configuration** (`eurl.php?mode=main&action=simple`)

Default URL: `/testimonials`

## File Structure

```
testimonials/
├── admin_config.php          # Admin panel controller
├── e_header.php              # Conditional CSS/JS asset loader
├── e_url.php                 # SEF URL configuration
├── plugin.xml                # Plugin manifest
├── testimonials.php          # Front-end submit page
├── testimonials_menu.php     # Carousel menu renderer
├── testimonials_setup.php    # Install/upgrade routines
├── testimonials_sql.php      # Database schema
├── css/
│   └── testimonials.css      # Plugin styles
├── images/
│   ├── testimonials_16.png   # Admin icon (16px)
│   └── testimonials_32.png   # Admin icon (32px)
├── js/
│   └── testimonials.js       # Read more/less toggle
├── languages/
│   ├── English/
│   │   ├── English_admin.php
│   │   ├── English_front.php
│   │   └── English_global.php
│   ├── Portuguese/
│   │   ├── Portuguese_admin.php
│   │   ├── Portuguese_front.php
│   │   └── Portuguese_global.php
│   └── Spanish/
│       ├── Spanish_admin.php
│       ├── Spanish_front.php
│       └── Spanish_global.php
├── shortcodes/
│   └── batch/
│       └── testimonials_shortcodes.php
└── templates/
    └── testimonials_template.php
```

## Database

The plugin creates a single table `testimonials`:

| Column | Type | Description |
|--------|------|-------------|
| `tm_id` | INT(11) | Primary key, auto-increment |
| `tm_name` | VARCHAR(50) | Author in format `UserID.Name` (0 = anonymous) |
| `tm_url` | VARCHAR(255) | Author homepage URL |
| `tm_message` | TEXT | Testimonial text |
| `tm_datestamp` | INT(10) | Unix timestamp of creation |
| `tm_blocked` | TINYINT(3) | 0 = active, 1 = pending approval |
| `tm_ip` | VARCHAR(45) | Author IP address |
| `tm_order` | TINYINT(3) | Display order |

## Translations

The plugin ships with three languages:

- **English** (default/fallback)
- **Spanish** (Español)
- **Portuguese** (Português)

To add a new language, create a folder under `languages/` with the e107 language name (e.g., `French/`) and copy the English files, renaming and translating them accordingly.

## Credits

- **Original Author**: [lonalore](http://lonalore.hu) (v3.0, 2015)
- **Modernized by**: Kanonimpresor project team (2026)
- **Theme**: Aeolus for e107 by [Jimako](https://www.e107sk.com)

## License

This plugin is released under the [GNU General Public License v2](https://www.gnu.org/licenses/gpl-2.0.html).
