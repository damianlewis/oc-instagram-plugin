# Instagram plugin for October CMS
Adds an Instagram feed to an October CMS website.

## Instructions
1. In the backend settings page, add the Access Token for your Instagram account.
2. Add the Instagram Feed component `{% component 'instagramFeed' %}` to your CMS page.

### Configuration
The Instagram Feed component can be used to display a feed of media items.
- `numberOfItems` - How many media items to fetch. The default value is 6.
- `noMediaItemsMessage` - Message to display when no items are returned from the Instagram feed.

The Instagram Feed component injects the following variables into the page where it's used:
- `instagramMediaItems` - An array of media items from the Instagram account.
- `noMediaItemsMessage` - The value of the component's `noMediaItemsMessage` property.
