# Managing Programs

Programs are the core content of the site. Each program (e.g. "Year-Round Nordic", "Junior Biathlon") is a custom post type entry that appears as a card on the relevant program page.

## How to Access

1. Log in to WordPress admin
2. Click **Programs** in the left sidebar (clipboard icon)

## Adding a New Program

1. Click **Programs > Add New Program**
2. Fill in the following:

### Basic Info (top section)

| Field | Purpose |
|-------|---------|
| **Title** | Program name displayed on the card (e.g. "Year-Round Nordic") |
| **Editor content** | Full description. On program page cards, this is truncated to ~4 lines. |
| **Featured Image** | Photo shown at the top of the program card. Set via the right sidebar. Recommended size: at least 700px wide. |

### Program Details (meta box below editor)

| Field | Purpose | Example |
|-------|---------|---------|
| **Status** | Controls which section the program appears in | "Open for Registration" or "Closed for the Season" |
| **Coach** | Coach name displayed on the card | John Richter |
| **Cost** | Price info displayed on the card | $175 per season |
| **Schedule** | When the program meets | Wednesdays 6:00-7:30pm, May-Aug |
| **Registration Link** | URL for the "Register" button on the card | https://... |

### Homepage Showcase (optional, bottom of meta box)

| Field | Purpose |
|-------|---------|
| **Featured** | Check to show this program in the homepage showcase grid (max 8 shown) |
| **Short Description** | Brief text for the homepage card (max 100 characters) |
| **Program Page Link** | URL to the full program page (used as the "Learn More" link on homepage) |

### Program Group (right sidebar)

Check the box for the group this program belongs to. This determines which program page it appears on:

| Group | Appears On Page |
|-------|----------------|
| Adult Nordic | Adult Nordic |
| Juniors | Juniors |
| Youth | Youth |
| Paddling - Junior | Paddling |
| Paddling - Adult Canoe | Paddling |
| Paddling - Clinics | Paddling |
| Cycling - Adult | Cycling |
| Cycling - Youth | Cycling |
| Trail Running | Trail Running |

A program can belong to multiple groups if needed.

3. Click **Publish**

## Editing an Existing Program

1. Go to **Programs** in the sidebar
2. Click the program name to edit
3. Make changes and click **Update**

## Opening / Closing a Program for the Season

1. Edit the program
2. Change the **Status** dropdown:
   - **Open for Registration** — appears in the main section with a "Register" button
   - **Closed for the Season** — appears in the "Closed for the Season" section (grayed out) with a "View Details" button
3. Click **Update**

## Deleting a Program

1. Hover over the program name in the list
2. Click **Trash**

## Tips

- Programs with no **Registration Link** will show the card without a button.
- Programs with no **Featured Image** will show the card without a photo header.
- Only fields that have content are displayed — blank fields are simply hidden.
- The **menu order** field (in Screen Options > enable "Page Attributes") controls the display order of programs within a group.
