# Theme Architecture

Technical reference for the EU-Theme WordPress theme.

## Theme Location

```
wp-content/themes/EU-Theme/
```

## Template Files

| File | Type | Description |
|------|------|-------------|
| `header.php` | Partial | HTML head, slogan ribbon, site header with logo, primary nav |
| `footer.php` | Partial | Footer columns (about, links, contact, social), copyright bar |
| `front-page.php` | Template | Homepage: hero slider, showcase grid, two-col boxes, feature grid, testimonials |
| `index.php` | Template | Blog/archive listing |
| `single.php` | Template | Single post view |
| `page.php` | Template | Default page template |
| `404.php` | Template | 404 error page |
| `template-program.php` | Page Template | "Program Page" — ACF-driven program pages with card grids |
| `template-hub.php` | Page Template | "Hub Page" — landing pages with card grids linking to sub-pages |
| `template-testimonials.php` | Page Template | "Testimonials" — all testimonials in card grid |
| `page-news.php` | Page Template | "News" — filtered news post grid with pagination |
| `page-board-of-directors.php` | Page Template | "Board of Directors" — hardcoded board member cards |
| `page-coaches.php` | Page Template | "Coaches" — hardcoded coach listings by section |
| `page-go-spring.php` | Page Template | "Go Spring!" — hardcoded race event page |
| `page-night-light.php` | Page Template | "Night Light" — hardcoded race event page |
| `page-turkey-day.php` | Page Template | "Turkey Day Trail Trot" — hardcoded race event page |

## Custom Post Types

### eu_program

Registered in `functions.php` via `eu_register_program_cpt()`.

**Supports:** title, editor, thumbnail

**Meta fields** (stored as post meta with `_eu_program_` prefix):

| Meta Key | Type | Purpose |
|----------|------|---------|
| `_eu_program_status` | string (`open`/`closed`) | Controls which section the program appears in |
| `_eu_program_link` | URL | Registration link |
| `_eu_program_coach` | text | Coach name |
| `_eu_program_cost` | text | Price info |
| `_eu_program_schedule` | text | Meeting schedule |
| `_eu_program_featured` | boolean (`1`/`0`) | Show on homepage showcase grid |
| `_eu_program_short_desc` | text (max 100 chars) | Homepage card description |
| `_eu_program_page_link` | URL | Full program page link for homepage card |

**Taxonomy:** `eu_program_group` (hierarchical, like categories)

### eu_testimonial

Registered in `functions.php` via `eu_register_testimonial_cpt()`.

**Supports:** title, editor

**Meta fields:**

| Meta Key | Type | Purpose |
|----------|------|---------|
| `_eu_testimonial_author` | text | Person's name |
| `_eu_testimonial_program` | text | Program or role context |
| `_eu_testimonial_featured` | boolean (`1`/`0`) | Show in homepage slider |

## Taxonomies

### eu_program_group

Hierarchical taxonomy for `eu_program`. Auto-created terms:

| Term | Auto-generated Slug |
|------|-------------------|
| Adult Nordic | adult-nordic |
| Juniors | juniors |
| Youth | youth |
| Paddling - Junior | paddling-junior |
| Paddling - Adult Canoe | paddling-adult-canoe |
| Paddling - Clinics | paddling-clinics |
| Cycling - Adult | cycling-adult |
| Cycling - Youth | cycling-youth |
| Trail Running | trail-running |

### News Categories (built-in taxonomy)

| Category | Slug |
|----------|------|
| Program News | program-news |
| Race Event News | race-event-news |
| Other News | other-news |

## ACF Field Groups

All registered in PHP via `acf_add_local_field_group()` in `functions.php`. This is ACF **Free** (6.7.1) — no repeaters, flexible content, or clone fields.

Pattern: multi-value content uses numbered individual fields (e.g. `slide_title_1` through `slide_title_8`).

### Site Settings (Options Page)

**Location:** `options_page == site-settings`

Fields: `site_slogan`, `office_email`, `office_phone`, `office_address`, `facebook_url`, `instagram_url`, `youtube_url`, `footer_about_text`, plus 4 slots each for Get Involved links (`get_involved_label_N`, `get_involved_url_N`) and Our Team links (`our_team_label_N`, `our_team_url_N`).

Accessed with: `get_field('field_name', 'option')`

### Program Page Fields

**Location:** `page_template == template-program.php`

Fields: `program_subtitle`, `program_intro`, `season_start_month`, `season_end_month`, `in_season_description`, `off_season_description`, `coaches_info`, `equipment_needs`, 3 special notes (`special_note_N`), 5 sections (`section_title_N`, `section_description_N`, `section_group_slug_N`), `show_closed_section`, `closed_section_message`.

### Hero Slider (Front Page)

**Location:** `page_type == front_page`

8 slide slots: `slide_title_N`, `slide_subtitle_N`, `slide_image_N`, `slide_bg_color_N`.

### Two Column Boxes (Front Page)

**Location:** `page_type == front_page`

2 box slots: `twocol_title_N`, `twocol_text_N`, `twocol_link_label_N`, `twocol_link_url_N`, `twocol_color_N`.

### Feature Grid (Front Page)

**Location:** `page_type == front_page`

4 feature slots: `feat_label_N`, `feat_title_N`, `feat_text_N`, `feat_cta_N`, `feat_url_N`, `feat_color_N`.

### Hub Page Cards

**Location:** `page_template == template-hub.php`

`hub_intro` + 6 card slots: `hub_card_title_N`, `hub_card_desc_N`, `hub_card_link_N`, `hub_card_image_N`, `hub_card_color_N`.

## Helper Functions

### eu_render_program_boxes($group_slug, $status = 'open')

Queries `eu_program` posts filtered by taxonomy group slug and status meta. Renders a responsive card grid (`.program-card-grid`) with thumbnail, title, coach, cost, schedule, description (line-clamped), and CTA button.

### eu_render_photo_gallery($title = 'Photo Gallery')

Renders a photo gallery from the current page's attached images. Includes a lightbox with keyboard navigation. Used on race event pages.

### EU_Nav_Walker

Custom `Walker_Nav_Menu` that adds `dropdown` class to parent `<li>` items, appends a ▼ indicator, and outputs sub-menus with `<ul class="submenu">`.

## Navigation

**Menu location:** `primary` (Primary Menu)

**Walker:** `EU_Nav_Walker`

**Fallback:** Hardcoded menu in `header.php` if no menu is assigned.

## Auto-Created Pages

The `eu_create_site_pages()` function runs on `init` and creates pages with the correct template assignment if they don't already exist. Each page has an option flag to prevent re-creation.

| Page | Slug | Template |
|------|------|----------|
| News | news | page-news.php |
| Testimonials | testimonials | template-testimonials.php |
| Nordic | nordic | template-hub.php |
| Programs | programs | template-hub.php |
| Urban Trail Series | urban-trail-series | template-hub.php |
| Go Spring! | go-spring | page-go-spring.php |
| Night Light | night-light | page-night-light.php |
| Turkey Day Trail Trot | turkey-day-trail-trot | page-turkey-day.php |
| Adult Nordic | adult-nordic | template-program.php |
| Juniors | juniors | template-program.php |
| Youth | youth | template-program.php |
| Paddling | paddling | template-program.php |
| Cycling | cycling | template-program.php |
| Trail Running | trail-running | template-program.php |

## Enqueued Assets

- **Google Fonts:** Oswald (600, 700), Inter (400, 600, 700)
- **Theme stylesheet:** `style.css` (versioned, currently `2.7`)

## CSS Class Conventions

Key class prefixes and their contexts:

| Prefix | Context |
|--------|---------|
| `.program-card-*` | Program card grid on program pages |
| `.showcase-*` | Homepage featured programs showcase |
| `.feature-*` | Homepage 2x2 feature grid |
| `.col-box` / `.two-col-boxes` | Homepage two-column boxes |
| `.testimonial-*` | Testimonial slider and cards |
| `.nordic-*` | Program page layout (intro, section titles, notes) |
| `.news-*` | News page cards, filters, pagination |
| `.cal-*` | Calendar page |
| `.event-*` | Event listing and detail pages |
| `.board-*` | Board of directors page |
| `.coach-*` | Coaches page |
| `.hub-*` | Hub page cards (ACF field names, not CSS — cards use `.showcase-*`) |
| `.eu-gallery-*` / `.eu-lightbox*` | Photo gallery and lightbox |
