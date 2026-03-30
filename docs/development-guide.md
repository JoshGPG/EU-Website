# Development Guide

Technical guide for developers working on the EU-Theme.

## Local Development Setup

### Requirements

- PHP 8.0+
- WordPress 6.x
- [Laravel Herd](https://herd.laravel.com/) (local dev environment)
- ACF (Advanced Custom Fields) Free 6.7.1 — installed as a plugin

### Getting Started

1. Clone the repo into your Herd sites directory
2. Set up a WordPress installation pointing to this repo
3. Activate the **EU-Theme** (in `wp-content/themes/EU-Theme/`)
4. Install and activate the **ACF** plugin (free version)
5. Visit any page — auto-created pages and taxonomy terms will be generated on first load

### File Structure

```
wp-content/themes/EU-Theme/
├── style.css              # All theme CSS (versioned via functions.php)
├── functions.php          # CPTs, meta boxes, ACF fields, helpers, enqueues
├── header.php             # Site header partial
├── footer.php             # Site footer partial
├── front-page.php         # Homepage template
├── index.php              # Blog archive
├── single.php             # Single post
├── page.php               # Default page
├── 404.php                # 404 page
├── template-program.php   # Program page template
├── template-hub.php       # Hub page template
├── template-testimonials.php  # Testimonials page template
├── page-news.php          # News page template
├── page-board-of-directors.php
├── page-coaches.php
├── page-go-spring.php
├── page-night-light.php
├── page-turkey-day.php
└── images/                # Theme images
```

## Key Coding Patterns

### ACF Free Limitations

ACF Free does **not** support:
- Repeater fields
- Flexible content fields
- Clone fields

**Workaround:** Use numbered individual fields for multi-slot content.

```php
// Instead of a repeater, use numbered slots:
for ($i = 1; $i <= 5; $i++) {
    $title = get_field('section_title_' . $i);
    if (!$title) continue; // blank = skip
    // ... render section
}
```

### ACF Field Registration

All ACF fields are registered in PHP (not via the ACF admin UI) for version control:

```php
function eu_register_acf_field_groups() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'      => 'group_unique_key',
        'title'    => 'Group Title',
        'fields'   => [ /* field definitions */ ],
        'location' => [ /* where the fields appear */ ],
    ]);
}
add_action('acf/init', 'eu_register_acf_field_groups');
```

### Options Page Fields

Access options page fields with the `'option'` second parameter:

```php
$slogan = get_field('site_slogan', 'option');
```

### Template Fallback Defaults

All templates should have fallback defaults when ACF fields are empty:

```php
$slogan = get_field('site_slogan', 'option') ?: 'ACTIVE. HEALTHY. OUTDOORS.';
```

### Custom Post Meta

Program and testimonial meta use the `_eu_` prefix and are saved/loaded with standard WordPress functions:

```php
// Save
update_post_meta($post_id, '_eu_program_coach', sanitize_text_field($value));

// Read
$coach = get_post_meta($post->ID, '_eu_program_coach', true);
```

### Rendering Program Cards

Use the helper function, not raw queries:

```php
// In a template:
eu_render_program_boxes('adult-nordic', 'open');
eu_render_program_boxes('adult-nordic', 'closed');
```

## CSS Conventions

### Single Stylesheet

All CSS lives in `style.css`. No preprocessors (Sass/Less) are used.

### Version Bumping

When changing CSS, bump the version in `functions.php`:

```php
wp_enqueue_style('mytheme-style', get_stylesheet_uri(), [], '2.7');
//                                                          ^^^
```

### Naming

- BEM-like flat classes: `.program-card-title`, `.program-card-meta`
- Section prefixes group related styles: `.nordic-*`, `.news-*`, `.event-*`
- Grid wrappers end in `-grid`: `.program-card-grid`, `.showcase-grid`, `.news-grid`

### Brand Colors

| Color | Hex | Usage |
|-------|-----|-------|
| EU Blue | `#2D62A5` | Primary brand, links, buttons, header elements |
| Dark Blue | `#245089` | Hover states, footer background |
| EU Red | `#B9313A` | Accent, category labels, some CTAs |
| Dark Text | `#1a1a2e` | Headings |
| Body Text | `#333` | Default text |
| Muted Text | `#888` | Secondary info, meta text |

### Fonts

| Font | Weights | Usage |
|------|---------|-------|
| Oswald | 600, 700 | (Available but primarily Montserrat is used for headings) |
| Inter | 400, 600, 700 | Feature grid boxes |
| Montserrat | — | Nav links, headings, labels (loaded via system/fallback) |
| System stack | — | Body text |

### Responsive Breakpoints

| Breakpoint | Behavior |
|------------|----------|
| `max-width: 1024px` | Showcase grid to 2 columns |
| `max-width: 700px` | Most grids to 1 column, reduced padding |
| `max-width: 600px` | Showcase grid to 1 column |

## Adding a New Program Page

1. Add the group term in `eu_create_program_groups()` in `functions.php`
2. Add the page entry in `eu_create_site_pages()` in `functions.php`
3. After the next page load, the page and term are auto-created
4. Edit the page in WP admin to set up sections with the correct group slug

## Adding New ACF Fields

1. Define the field in the appropriate field group array in `functions.php`
2. Use the field in the relevant template with `get_field()`
3. Add fallback defaults where appropriate

## Deployment

The theme is version-controlled via Git. Deploy by pushing to the main branch and pulling on the server (or your preferred deployment method).

Key files to never commit:
- `wp-config.php` (contains database credentials)
- `/wp-content/uploads/` (media files — manage separately)
- Any `.env` files
