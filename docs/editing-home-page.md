# Editing the Home Page

The home page is built from several sections, each controlled by ACF fields. To edit, go to **Pages** and edit the page set as the **Static Front Page** (under Settings > Reading).

## Sections (top to bottom)

### 1. Hero Slider

Up to **8 slides** that auto-rotate every 15 seconds.

Each slide has:

| Field | Purpose |
|-------|---------|
| **Title** | Large heading text. **Leave blank to hide the slide.** |
| **Subtitle** | Smaller text below the title |
| **Background Image** | Full-width photo behind the text |
| **Background Color** | Fallback color (shown while image loads or if no image is set) |

The first 4 slides have defaults pre-filled. Slides 5-8 are blank by default.

### 2. Featured Programs Showcase

This section is **automatic** — it pulls from the Programs custom post type. No fields to edit on the home page itself.

To control which programs appear:
1. Go to **Programs** and edit a program
2. Check the **Featured** checkbox in the "Homepage Showcase" section
3. Fill in the **Short Description** (max 100 characters)
4. Fill in the **Program Page Link** (for the "Learn More" link)

Up to 8 featured programs will display in a responsive grid.

### 3. Two Column Boxes

Two side-by-side info boxes. Each box has:

| Field | Purpose | Default |
|-------|---------|---------|
| **Title** | Box heading | "Latest News" / "Upcoming Events" |
| **Text** | Description paragraph | Pre-filled |
| **Link Label** | Button text | "Read More" / "View Events" |
| **Link URL** | Where the button goes | /news/ / /events/ |
| **Background Color** | Box color | EU blue shades |

### 4. Feature Grid (2x2)

Four feature boxes in a 2x2 grid. Each box has:

| Field | Purpose |
|-------|---------|
| **Label** | Small uppercase text above the title (e.g. "Upcoming Race"). **Leave blank to hide this box.** |
| **Title** | Main heading |
| **Description** | Short paragraph |
| **Button Text** | CTA text |
| **Link URL** | Where the box links to |
| **Background Color** | Box color |

### 5. Testimonials Slider

This section is **automatic** — it pulls from the Testimonials custom post type. See [Managing Testimonials](./managing-testimonials.md) for details on controlling what appears here.

## Tips

- The hero slider and testimonials slider don't need page editing — they're automatic. Just manage the underlying content (slides via ACF fields, testimonials via the Testimonials post type).
- For the Two Column Boxes and Feature Grid, all fields have defaults. Only edit what you want to change.
- Use the color picker to match EU brand colors (primary blue: `#2D62A5`, red accent: `#B9313A`).
