Wordpress JSON API Extension (wp-json-api-ext)
==============================================
Extension controller for JSON API plugin (Wordpress)

Installation
============
1. Copy secursive.php from this repository to wp-content/plugins/json-api/controllers directory.
2. In Wordpress administration, go to JSON-API plugin settings.
3. Activate this plugin.

Examples
=========


===get_categories_posts()===
Function for retrieving posts from multiple categories (comma separated category id(s) or slug(s))

inputs:
1. slug=cata,catb,catc
OR
1. id=1,2,3

http://example.com/api/secursive/get_categories_posts/?dev=1&slug=cata,catb,catc
http://example.com/api/secursive/get_categories_posts/?dev=1&slug=1,2,3


===get_home()===
Function for retrieving n posts from groups of categories (input n)

inputs:
1. n=3

http://example.com/api/secursive/get_home/?dev=1&n=10


===send_email()===
Function for sending email (with arguments inserted in the body of message)

inputs:
1. firstname=FirstName
2. lastname=LastName
3. email=emailaddress
4. phone=phonenumber

http://example.com/api/secursive/get_categories_posts/?dev=1&firstname=test&lastname=test2&email=test3&phone=test4
