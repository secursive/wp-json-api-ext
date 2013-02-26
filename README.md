Wordpress JSON API Extension (wp-json-api-ext)
==============================================
Extension controller for JSON API plugin (Wordpress)

Installation
============
1. Copy secursive.php from this repository to wp-content\plugins\json-api\controllers directory.
2. In Wordpress administration, go to JSON-API plugin settings.
3. Activate this plugin.

Examples
=========

get_categories_posts():
Function for retrieving posts from multiple categories (comma separated category id(s) or slug(s))
http://example.com/api/secursive/get_categories_posts/?dev=1&slug=cata,catb,catc
http://example.com/api/secursive/get_categories_posts/?dev=1&slug=1,2,3

