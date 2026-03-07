# Plugin Testimonios para e107

#### (Elija su idioma abajo / Choose your language below / Escolha o seu idioma abaixo)

[![Language-English](https://img.shields.io/badge/Language-English-blue)](README.md) 
[![Language-Português](https://img.shields.io/badge/Language-Português-green)](README.pt-PT.md) 
[![Language-Español](https://img.shields.io/badge/Language-Español-red)](README.es-ES.md) 

Un plugin moderno de testimonios para **e107 v2.x** que muestra testimonios de clientes en un carrusel Bootstrap 5 y proporciona un formulario de envío en el frontend.

## Características

- **Carrusel Bootstrap 5** — Slider responsivo de testimonios con indicadores y controles de navegación.
- **Formulario de Envío en el Frontend** — Los usuarios autenticados pueden enviar testimonios directamente desde el sitio web.
- **Soporte de Captcha** — Captcha opcional con imagen segura de e107 en el formulario de envío.
- **Flujo de Aprobación** — Los testimonios enviados pueden requerir aprobación del administrador antes de publicarse.
- **Panel de Administración** — Gestión CRUD completa a través del Admin UI de e107 (listar, crear, editar, eliminar, reordenar).
- **Truncado de Texto** — Límite configurable de caracteres con alternancia interactiva "Leer más / Leer menos".
- **URLs SEF** — Soporte de URLs amigables con alias editable a través del gestor de URLs de e107.
- **Multi-idioma** — Soporte completo de i18n con traducciones en Inglés, Español y Portugués.
- **Accesible** — Etiquetas ARIA, navegación por teclado y soporte para lectores de pantalla.

## Requisitos

- e107 v2.3.1 o superior
- PHP 8.0 o superior
- Bootstrap 5.x (cargado por e107 o el tema)
- FontAwesome 5.x (cargado por e107 o el tema)

## Instalación

1. Suba la carpeta `testimonials` a `e107_plugins/`.
2. Vaya a **Admin > Gestor de Plugins** e instale el plugin.
3. Vaya a **Admin > Menús** y coloque `testimonials_menu` en un área de menú de la(s) página(s) deseada(s).
4. Configure el plugin en **Admin > Testimonios**.

## Configuración

Navegue hasta **Admin > Testimonios > Ajustes**:

| Ajuste | Descripción | Predeterminado |
|--------|-------------|----------------|
| Número de testimonios para mostrar | Cuántos testimonios mostrar en el carrusel | 3 |
| Longitud máxima de los mensajes | Límite de caracteres de los mensajes mostrados (0 = sin límite) | 250 |
| Clase de usuario que puede enviar | Qué clase de usuario puede acceder al formulario de envío | Miembros |
| Usar captcha en el formulario | Activar/desactivar verificación por captcha | Sí |
| ¿Se requiere aprobación? | Requerir aprobación del administrador para nuevos envíos | Sí |

## Configuración de URLs

El plugin registra una ruta de URL SEF. Puede personalizar el alias de la URL en:

**Admin > Ajustes > Configuración de URLs** (`eurl.php?mode=main&action=simple`)

URL predeterminada: `/testimonials`

## Estructura de Archivos

```
testimonials/
├── admin_config.php          # Controlador del panel de administración
├── e_header.php              # Carga condicional de CSS/JS
├── e_url.php                 # Configuración de URLs SEF
├── plugin.xml                # Manifiesto del plugin
├── testimonials.php          # Página de envío en el frontend
├── testimonials_menu.php     # Renderizador del menú carrusel
├── testimonials_setup.php    # Rutinas de instalación/actualización
├── testimonials_sql.php      # Esquema de la base de datos
├── css/
│   └── testimonials.css      # Estilos del plugin
├── images/
│   ├── testimonials_16.png   # Icono admin (16px)
│   └── testimonials_32.png   # Icono admin (32px)
├── js/
│   └── testimonials.js       # Alternancia Leer más/menos
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

## Base de Datos

El plugin crea una tabla única `testimonials`:

| Columna | Tipo | Descripción |
|---------|------|-------------|
| `tm_id` | INT(11) | Clave primaria, auto-incremento |
| `tm_name` | VARCHAR(50) | Autor en formato `IDUsuario.Nombre` (0 = anónimo) |
| `tm_url` | VARCHAR(255) | URL de la página personal del autor |
| `tm_message` | TEXT | Texto del testimonio |
| `tm_datestamp` | INT(10) | Timestamp Unix de la creación |
| `tm_blocked` | TINYINT(3) | 0 = activo, 1 = pendiente de aprobación |
| `tm_ip` | VARCHAR(45) | Dirección IP del autor |
| `tm_order` | TINYINT(3) | Orden de presentación |

## Traducciones

El plugin incluye tres idiomas:

- **Inglés** (predeterminado/fallback)
- **Español** (Español)
- **Portugués** (Português)

Para añadir un nuevo idioma, cree una carpeta en `languages/` con el nombre del idioma e107 (ej.: `French/`) y copie los archivos ingleses, renombrándolos y traduciéndolos adecuadamente.

## Créditos

- **Autor Original**: [lonalore](http://lonalore.hu) (v3.0, 2015)
- **Modernizado por**: Equipo del proyecto Royal Bus (2026)
- **Tema**: Aeolus para e107 por [Jimako](https://www.e107sk.com)

## Licencia

Este plugin se distribuye bajo la [GNU General Public License v2](https://www.gnu.org/licenses/gpl-2.0.html).