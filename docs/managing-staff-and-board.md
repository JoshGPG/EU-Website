# Managing Staff, Coaches & Board Members

All coaches and board members are managed from a single place: the **Staff & Board** section in the WordPress admin. They appear automatically on the **Coaches** page and **Board of Directors** page based on which group they're assigned to.

## How to Access

1. Log in to WordPress admin
2. Click **Staff & Board** in the left sidebar (people icon)

## Adding a New Coach or Staff Member

1. Click **Staff & Board > Add New Member**
2. Fill in the following:

| Field | Where | Purpose | Example |
|-------|-------|---------|---------|
| **Title** | Top of editor | Person's name | "John Richter" |
| **Editor content** | Main editor area | Bio paragraph (optional) | "I've been coaching Nordic skiing for 15 years..." |
| **Featured Image** | Right sidebar | Photo (optional) | Upload a headshot |
| **Role / Title** | "Staff Details" box below editor | Their role or coaching assignment | "Adult Team Coach: Tuesday West PM" |
| **Email** | "Staff Details" box below editor | Contact email (optional) | "john@enduranceunited.org" |
| **Staff Groups** | Right sidebar checkboxes | Which page section they appear in | Check "Adult Team Coaches" |
| **Order** | Page Attributes box, right sidebar | Sort order within their group (lower = first) | 0, 1, 2, etc. |

3. Click **Publish**

The person will immediately appear on the appropriate page.

## Available Groups

| Group | Appears On |
|-------|-----------|
| Board of Directors | Board of Directors page |
| Youth Coaches | Coaches page — "Youth Coaches" section |
| Adult Team Coaches | Coaches page — "Adult Team Coaches" section |
| Adult Learn to Ski Coaches | Coaches page — "Adult Learn to Ski Coaches" section |
| Adult Intermediate Ski Coaches | Coaches page — "Adult Intermediate Ski Coaches" section |
| Junior Coaches | Coaches page — "Junior Coaches" section |
| Mountain Bike Coaches | Coaches page — "Mountain Bike Coaches" section |
| Paddle Coaches | Coaches page — "Paddle Coaches" section |
| Guest Nordic Coaches | Coaches page — "Guest Nordic Coaches" section |

A person can belong to multiple groups (e.g. someone who coaches both adult skiing and mountain biking).

## Card Layout — How It's Determined

The layout for each section is automatic:

- **If anyone in the group has a bio** (editor content): The entire group displays as **feature cards** — larger cards with photo on the left and name/role/bio on the right
- **If nobody in the group has a bio**: The group displays as a **compact grid** — small cards with photo, name, and role
- **Board of Directors**: Always uses the compact grid regardless of bios

This means you can upgrade a section's look simply by adding a bio to one of its members.

## Adding a Board Member

Same steps as adding a coach:

1. **Staff & Board > Add New Member**
2. Enter their name
3. Set the role (e.g. "President", "Secretary", "Board Member")
4. Check **Board of Directors** in the Staff Groups sidebar
5. Optionally add a photo
6. Publish

## Editing an Existing Member

1. Go to **Staff & Board** in the sidebar
2. Click the person's name
3. Make changes and click **Update**

## Removing a Member

1. Hover over their name in the Staff & Board list
2. Click **Trash**

## Reordering Members Within a Group

Members display in the order set by the **Order** field:

1. Edit the staff member
2. In the right sidebar, find **Page Attributes** (enable via Screen Options if not visible)
3. Set the **Order** number (0 = first, 1 = second, etc.)
4. Click **Update**

Members with the same order number are sorted alphabetically by name.

## Tips

- **Photos**: Use square or portrait-oriented photos. They'll be cropped to a circle. Recommended size: at least 300x300px.
- **No photo?** A gray placeholder circle appears automatically.
- **Bios**: Keep bios to 1-2 paragraphs. They appear directly on the Coaches page — there's no "read more" link.
- **Email**: Only add if you want the email publicly visible on the website.
- **Multiple roles**: If someone coaches in multiple groups, add them once and check multiple groups. They'll appear in each section.
