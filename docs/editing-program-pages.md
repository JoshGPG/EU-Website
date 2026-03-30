# Editing Program Pages

Program pages (Adult Nordic, Juniors, Youth, Paddling, Cycling, Trail Running) all use the same **Program Page** template. Content is managed via ACF fields in the page editor.

## How to Access

1. Go to **Pages** in the WordPress admin
2. Click on the program page you want to edit (e.g. "Adult Nordic")
3. The ACF fields appear below the main editor

## Page Fields

### Basic Info

| Field | Purpose |
|-------|---------|
| **Subtitle** | Optional text below the page title (e.g. "MyXC affiliated program") |
| **Introduction** | WYSIWYG editor for the intro paragraphs at the top of the page |

### Season-Aware Description

These fields let you show different content based on the time of year:

| Field | Purpose |
|-------|---------|
| **Season Start Month** | When the active season begins |
| **Season End Month** | When the active season ends |
| **In-Season Description** | Content shown during the active season |
| **Off-Season Description** | Content shown outside the active season |

Leave the months blank to skip season-based content entirely.

**Example:** If start = May and end = April, the in-season description shows May through April, and off-season shows only during... well, never (it wraps the year). A more typical setup: start = November, end = March for a winter program.

### Coaches

| Field | Purpose |
|-------|---------|
| **Coaches** | WYSIWYG content about the coaching staff. Leave blank to hide this section. |

### Equipment

| Field | Purpose |
|-------|---------|
| **Equipment Needs** | WYSIWYG content about required/recommended gear. Leave blank to hide this section. |

### Special Notes (3 slots)

Optional notes displayed as highlighted blocks (e.g. "Ski pass required", "Program is weather-dependent").

Leave blank to skip.

### Program Sections (5 slots)

This is the key part. Each section creates a heading + optional description + a grid of program cards pulled from the Programs post type.

| Field | Purpose |
|-------|---------|
| **Section Title** | Heading text. **Leave blank to skip this section.** |
| **Section Description** | Optional WYSIWYG content below the heading |
| **Program Group Slug** | The slug of the Program Group taxonomy term. Programs assigned to this group will appear as cards. |

**Common group slugs:**

| Slug | Use For |
|------|---------|
| `adult-nordic` | Adult Nordic page |
| `juniors` | Juniors page |
| `youth` | Youth page |
| `paddling-junior` | Paddling page — Junior section |
| `paddling-adult-canoe` | Paddling page — Adult Canoe section |
| `paddling-clinics` | Paddling page — Clinics section |
| `cycling-adult` | Cycling page — Adult section |
| `cycling-youth` | Cycling page — Youth section |
| `trail-running` | Trail Running page |

**Example Setup for the Adult Nordic page:**
- Section 1: Title = "Programs", Group Slug = `adult-nordic`

**Example Setup for the Paddling page (multiple sections):**
- Section 1: Title = "Junior Paddling", Group Slug = `paddling-junior`
- Section 2: Title = "Adult Canoe", Group Slug = `paddling-adult-canoe`
- Section 3: Title = "Clinics & Workshops", Group Slug = `paddling-clinics`

### Closed Section

| Field | Purpose |
|-------|---------|
| **Show Closed Section** | Toggle to show/hide the "Closed for the Season" section at the bottom |
| **Closed Section Message** | Text displayed above the closed program cards |

Programs marked as "Closed for the Season" (in their individual program post) will automatically appear here in a grayed-out state.

## How Program Cards Work

The program cards that appear under each section are pulled automatically from the **Programs** post type. Each card shows:

- Program title
- Coach name (if filled in)
- Cost (if filled in)
- Schedule (if filled in)
- Description (truncated to ~4 lines)
- Featured image (if set)
- Register/View Details button (if registration link is filled in)

To change what appears on a card, edit the **Program** post itself — not the page. See [Managing Programs](./managing-programs.md).

## Tips

- You can use up to 5 sections per page. Most pages only need 1 (simple programs like Adult Nordic) or 2-3 (multi-category pages like Paddling or Cycling).
- The group slug must match exactly. Check **Programs > Program Groups** in the admin to verify slug names.
- Programs with status "Open" appear in the main sections. Programs with status "Closed" appear in the closed section at the bottom.
