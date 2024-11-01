=== WP FreeStyle Wiki ===
Contributors: jfut
Tags: wiki, Post, posts, page, pages, syntax, markup
Requires at least: 2.8
Tested up to: 3.0.4
Stable tag: 0.2.2

This plugin allows you to use FreeStyle Wiki syntax for typing up your posts
and pages.

== Description ==

WP FreeStyle Wiki is yet another markup plugin for WordPress. It lets you
FreeStyle Wiki syntax in your markup. It includes original FreeStyle Wiki
3.6.4.

* FreeStyle Wiki: http://fswiki.sourceforge.jp/cgi-bin/wiki.cgi

== Installation ==

1. Upload `wp-freestyle-wiki` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create new port or page
1. Add fswiki text into [fswiki][/fswiki] tag

== Frequently Asked Questions ==

= What is the FreeStyle Wiki? =

The FreeStyle Wiki(fswiki) is famous wiki system in Japan.

* FreeStyle Wiki: http://fswiki.sourceforge.jp/cgi-bin/wiki.cgi

= How do I add a FreeStyle Wiki plugin? =

This plugin includes the FreeStyle Wiki 3.6.4.
You can add a FreeStyle Wiki plugin to `/wp-content/plugins/wp-freestyle-wiki/fswiki/plugin`.
And you should add the plugin name to `/wp-content/plugins/wp-freestyle-wiki/fswiki/config/plugin.dat`.

= I would like to modify stylesheet =

This plugin convert html into `<div class="fswiki_content" />` element.
Please add style (ex. .fswiki_content h1 {...}) to your css file in theme. 
And you should override style on `/wp-content/plugins/wp-freestyle-wiki/fswiki.css'.

== Screenshots ==

1. The markup example
2. The working example

== Upgrade Notice ==

Nothing.

== Changelog ==

= 0.2.2 =

* Added execute permission if it is not

= 0.2.1 =

* Improved Frequently Asked Questions documentation

= 0.2 =

* Updated to FreeStyle Wiki 3.6.4
* Disable auto_keyword_page configuration

= 0.1.1 =

* Improved convert_html by using STDIN

= 0.1 =

* Initial release
