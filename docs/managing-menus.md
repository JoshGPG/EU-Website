# Managing Menus

The site uses a single primary navigation menu displayed in the header.

## How to Access

1. Go to **Appearance > Menus** in the WordPress admin
2. Select the menu assigned to the **Primary Menu** location (or create one)

## Menu Structure

The recommended menu structure with dropdowns:

```
Nordic ▼
  ├── Adult Nordic
  ├── Juniors
  └── Youth
Programs ▼
  ├── Paddling
  ├── Cycling
  └── Trail Running
Urban Trail Series ▼
  ├── Go Spring!
  ├── Night Light
  └── Turkey Day Trail Trot
News ▼
  ├── Program News
  ├── Race Event News
  └── Other News
Testimonials
```

## Creating/Editing the Menu

1. Go to **Appearance > Menus**
2. Select an existing menu or create a new one
3. Add pages from the left panel by checking them and clicking **Add to Menu**
4. Drag items to reorder
5. Drag items slightly to the right to make them sub-items (creates a dropdown)
6. Under **Menu Settings** at the bottom, check **Primary Menu** as the display location
7. Click **Save Menu**

## How Dropdowns Work

- Any top-level menu item with sub-items automatically gets a dropdown arrow (▼)
- Sub-items appear in a flyout menu on hover
- The theme's custom nav walker (`EU_Nav_Walker`) adds the correct CSS classes automatically:
  - Parent items get a `dropdown` class
  - Sub-menus get a `submenu` class

## Adding Custom Links

To add links that aren't pages (e.g. news category filters):

1. In the menu editor, expand **Custom Links** in the left panel
2. Enter the URL and link text
3. Click **Add to Menu**

**Common custom links:**
- Program News: `/news/?category=program-news`
- Race Event News: `/news/?category=race-event-news`

## Fallback Menu

If no menu is assigned to the Primary Menu location, a hardcoded fallback menu is displayed with the default site structure. Assign a custom menu to override this.

## Tips

- Keep the top-level items to 5-6 maximum for good horizontal fit.
- Dropdown menus appear on hover — they work on desktop but not on mobile (consider a mobile menu solution for the future).
- You can add CSS classes to individual menu items by enabling **CSS Classes** in the **Screen Options** tab at the top of the menu editor.
