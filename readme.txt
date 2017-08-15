=== micro.blog Tools ===
Contributors: magicroundabout
Tags: microblogging
Requires at least: 4.7
Tested up to: 4.8.1
Stable tag: 0.1.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Some handy tools that make using WordPress with the Micro.blog platform a bit nicer

== Description ==

This plugin does a few handy things that make using WordPress as a source for a Microblog on the Micro.blog platform a little nicer.

Currently the plugin will:

*   Set titles to the date and time of the post if the title is empty (it should be if posting from the micro.blog app)
*   Convert any URL's or email addresses to HTML link tags when saving a post
*   Convert any hashtags into links to a search for that hashtag

Coming soon (maybe):

*   A "Quick post" Dashboard Widget that will allow you to create a Microblog post from the WordPress dashboard

Note: This plugin assumes that running your Microblog is the only thing your WordPress install does. It assumes that posts are used for your microblog posts, and that you don't use any post formats or anything fancy. This plugin may mess up your site if it is set to work differently.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `microblog-tools.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Why are there no frequently asked questions? =

No one has asked me any question yet.

== Changelog ==

= 0.1.1 =
* Fixes for hashtag matching

= 0.1 =
* Initial relese with some very basic functionality

== Upgrade Notice ==

