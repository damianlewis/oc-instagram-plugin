# Instagram
Instagram feed for OctoberCMS.

### Media items
The `instagramFeed` component can be used to display a feed of media items.
- **numberOfItems** - How many media items to fetch. The default value is 6.
- **noMediaItemsMessage** - Message to display when no items are returned from the Instagram feed. The default is `No media items found`.

The instagramFeed component injects the following variables into the page where it's used:
- **instagramMediaItems** - An array of media items from the Instagram account.
- **noMediaItemsMessage** - The value of the component's `noPostsMessage` property.
