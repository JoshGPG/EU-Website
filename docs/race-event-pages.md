# Race Event Pages

Three race event pages have custom templates with hardcoded content:

- **Go Spring!** (`/go-spring/`) — template: `page-go-spring.php`
- **Night Light** (`/night-light/`) — template: `page-night-light.php`
- **Turkey Day Trail Trot** (`/turkey-day-trail-trot/`) — template: `page-turkey-day.php`

## Current State

These pages have their content **hardcoded in PHP templates** rather than managed through the WordPress editor or ACF fields. This means:

- To change text, fees, schedules, or other content, the PHP template files must be edited directly
- Each page includes race-specific sections (fees, schedule, course info, awards, past results, etc.)
- Each page includes a **photo gallery** with lightbox functionality (photos are uploaded as page attachments)

## Editing Content

Since content is hardcoded, changes require editing the template files:

| Page | File to Edit |
|------|-------------|
| Go Spring! | `wp-content/themes/EU-Theme/page-go-spring.php` |
| Night Light | `wp-content/themes/EU-Theme/page-night-light.php` |
| Turkey Day Trail Trot | `wp-content/themes/EU-Theme/page-turkey-day.php` |

## Managing Photo Galleries

Each race page includes an auto-generated photo gallery. To add photos:

1. Go to **Pages** and edit the race page
2. Click **Add Media** in the editor area
3. Upload photos — they become **attachments** of the page
4. The gallery automatically displays all image attachments in a grid with a lightbox viewer
5. The gallery title defaults to "Photo Gallery" but can be customized in the template

Gallery features:
- Click any photo to open the lightbox
- Navigate with arrows or keyboard (left/right/escape)
- Click outside the image to close

## Future Improvement

These pages would benefit from being converted to ACF-managed content (similar to how program pages work) so that race details can be updated from the WordPress admin without code changes.
