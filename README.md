Wordpress JSON API Extension (wp-json-api-ext)
==============================================
Extension controller for JSON API plugin (Wordpress)

Installation
============
* Copy secursive.php from this repository to wp-content/plugins/json-api/controllers directory.
* In Wordpress administration, go to JSON-API plugin settings.
* Activate this plugin.

Usage
=====

> get_categories_posts()

Function for retrieving posts from multiple categories (comma separated category id(s) or slug(s))

inputs:
* slug=cata,catb,catc

OR

* id=1,2,3

http://example.com/api/secursive/get_categories_posts/?dev=1&slug=cata,catb,catc

http://example.com/api/secursive/get_categories_posts/?dev=1&slug=1,2,3


> get_home()

Function for retrieving n posts from groups of categories (input n)

inputs:
* n=3

http://example.com/api/secursive/get_home/?dev=1&n=10


> send_email()

Function for sending email (with arguments inserted in the body of message)

inputs:
* firstname=FirstName
* lastname=LastName
* email=emailaddress
* phone=phonenumber

http://example.com/api/secursive/get_categories_posts/?dev=1&firstname=test&lastname=test2&email=test3&phone=test4
