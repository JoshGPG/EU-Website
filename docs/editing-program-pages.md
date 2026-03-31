# Editing Program Pages

Program pages (Adult Nordic, Juniors, Youth, Paddling, Cycling, Trail Running) all use the same **Program Page** template. Content is managed via ACF fields in the page editor.

## How Programs Appear Automatically

Programs show up on pages **automatically** based on the program group. When you create a program and assign it to the "Adult Nordic" group, it will appear on the Adult Nordic page — no extra configuration needed.

This works because the page slug matches the group slug:

| Page | Page Slug | Program Group |
|------|-----------|--------------|
| Adult Nordic | `adult-nordic` | Adult Nordic |
| Juniors | `juniors` | Juniors |
| Youth | `youth` | Youth |
| Trail Running | `trail-running` | Trail Running |

**To make a program show up on a page:**
1. Go to **Programs > Add New**
2. Fill in the program details (title, coach, cost, schedule, etc.)
3. In the right sidebar, check the matching **Program Group** (e.g. "Adult Nordic")
4. Set Status to "Open for Registration"
5. Publish

That's it. The program card will appear on the page automatically.

## Page Layout

Each program page displays in this order:

1. **Title** + subtitle
2. **Season description** (changes automatically based on time of year)
3. **Introduction** (rich text)
4. **Special notes**
5. **Coaches** section
6. **Equipment** section
7. **Open for Registration** — program cards with status "Open"
8. **Closed for the Season** — program cards with status "Closed" (grayed out, only shown if closed programs exist)
9. **Photo Gallery** — automatically shows images uploaded to the page
10. **Additional Information** — rich text content at the bottom

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

### Program Sections (5 slots) — Advanced, for multi-group pages only

Most pages don't need this. Sections are only needed for pages that pull from **multiple** program groups (like Paddling or Cycling).

| Field | Purpose |
|-------|---------|
| **Section Title** | Heading text. **Leave blank to skip this section.** |
| **Section Description** | Optional WYSIWYG content below the heading |
| **Program Group Slug** | The slug of the Program Group taxonomy term |

**When to use sections:** Only for pages like Paddling (3 sub-groups) and Cycling (2 sub-groups):

- Paddling: Section 1 = "Junior Paddling" / `paddling-junior`, Section 2 = "Adult Canoe" / `paddling-adult-canoe`, Section 3 = "Clinics" / `paddling-clinics`
- Cycling: Section 1 = "Adult Cycling" / `cycling-adult`, Section 2 = "Youth Cycling" / `cycling-youth`

**For simple pages (Adult Nordic, Juniors, Youth, Trail Running): leave all sections blank.** Programs will show up automatically.

### Closed Section

| Field | Purpose |
|-------|---------|
| **Show Closed Section** | Toggle to show/hide the "Closed for the Season" section (defaults to on) |
| **Closed Section Message** | Text displayed above the closed program cards |

The closed section only appears if there are actually closed programs — it won't show an empty heading.

### Additional Information

| Field | Purpose |
|-------|---------|
| **Additional Information (Bottom of Page)** | WYSIWYG content displayed below the photo gallery at the very bottom of the page |

### Photo Gallery

The photo gallery is automatic. To add photos:

1. Edit the program page
2. Click **Add Media** in the editor area
3. Upload images — they become attachments of the page
4. The gallery automatically appears with a lightbox viewer

## How Program Cards Work

The program cards are pulled automatically from the **Programs** post type. Each card shows:

- Program title
- Coach name (if filled in)
- Cost (if filled in)
- Schedule (if filled in)
- Description (truncated to ~4 lines)
- Featured image (if set)
- Register/View Details button (if registration link is filled in)

To change what appears on a card, edit the **Program** post itself — not the page. See [Managing Programs](./managing-programs.md).

## Tips

- **Simple pages** (Adult Nordic, Juniors, Youth, Trail Running): Just add programs to the matching group. No page configuration needed beyond optional intro text.
- **Multi-group pages** (Paddling, Cycling): Use the Section fields to create sub-sections with different group slugs.
- Programs with status "Open" appear under "Open for Registration". Programs with status "Closed" appear under "Closed for the Season".
- The closed section is smart — it only shows up when there are actually closed programs.
