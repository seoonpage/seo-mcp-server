=== OnPage.dev ===
Contributors: onpagedev
Tags: seo, ai, yoast, rank math, mcp
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.1.0
License: MIT

Approve SEO fixes from your AI assistant with one click. Every change shows old and new value and can be undone.

== Description ==

Connect your AI assistant (Claude, ChatGPT, Cursor and other MCP clients) to OnPage.dev at https://onpage.dev/mcp. When it finds SEO fixes for a page, it sends them to this plugin instead of editing your site.

In Tools, OnPage.dev you see every proposed change with the current and the new value. Approve the ones you want with one click. The plugin writes them through Yoast SEO or Rank Math when one of them is active, or outputs the tags itself. Every applied change can be undone.

Fields: SEO title, meta description, canonical URL, social title, description and image, JSON-LD structured data, image alt texts in the media library, new posts and pages (saved as drafts) and updated post text (shown as removed and added paragraphs).

= Privacy =

Connecting sends this site's address to onpage.dev and creates a site key. The plugin then fetches proposed changes from onpage.dev when you open its page, and reports which ones you applied, with the old values. OnPage.dev never logs in to your site and cannot change anything without your approval. Disconnecting or deleting the plugin removes the site and its change sets from onpage.dev. Privacy policy: https://onpage.dev/privacy

== Frequently Asked Questions ==

= Can the AI change my site without me? =

No. Changes wait in Tools, OnPage.dev until an administrator approves them.

= Does it publish posts? =

No. New posts and pages arrive as drafts that you publish yourself. An update to an existing post goes live only when you approve it, and undo restores the old text unless the post was edited since.

= Which pages are supported? =

Posts, pages and custom post types with their own URL, and a static front page. Archive pages are not supported yet.

== Changelog ==

= 1.1.0 =
* New posts and pages from your AI assistant, saved as drafts.
* Updated post text with removed and added paragraphs side by side.
* Undo keeps edits made after the change.

= 1.0.0 =
* First release.
