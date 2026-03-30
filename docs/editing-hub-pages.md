# Editing Hub Pages

Hub pages are summary/landing pages that link out to sub-pages. Currently used for:
- **Nordic** (`/nordic/`)
- **Programs** (`/programs/`)
- **Urban Trail Series** (`/urban-trail-series/`)

They all use the **Hub Page** template.

## How to Access

1. Go to **Pages** in the WordPress admin
2. Click the hub page you want to edit
3. The ACF fields appear below the main editor

## Page Fields

### Page Introduction

A short intro paragraph displayed below the page title. Optional.

### Cards (6 slots)

Up to **6 cards** displayed in a responsive grid. Each card has:

| Field | Purpose |
|-------|---------|
| **Title** | Card heading. **Leave blank to hide this card.** |
| **Description** | Short text on the card |
| **Link** | URL the card links to (usually a sub-page) |
| **Image** | Optional card image. If empty, the background color is shown instead. |
| **Background Color** | Fallback color for the card image area (default: dark blue) |

## Example Setup

**Nordic Hub Page:**
- Card 1: Title = "Adult Nordic", Description = "Year-round training for adult skiers", Link = `/adult-nordic/`
- Card 2: Title = "Juniors", Description = "Competitive programs for ages 14-18", Link = `/juniors/`
- Card 3: Title = "Youth", Description = "Fun and fundamentals for ages 6-13", Link = `/youth/`

## Tips

- Cards auto-arrange in a responsive grid (up to 4 columns on wide screens, 2 on tablet, 1 on mobile).
- Upload images that are at least 600px wide for best quality.
- Only cards with a filled-in title will appear. Leave unused slots blank.
