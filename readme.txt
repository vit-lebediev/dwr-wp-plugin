=== Donate With Robokassa ===
Contributors: Malgin
Donate link: http://vertdider.com/pomoshh-proektu/
Tags: donation, robokassa
Requires at least: 3.6.1
Tested up to: 3.6.1
Stable tag: trunk
License: MIT
License URI: http://opensource.org/licenses/MIT

'Donate With Robokassa' WordPress plugin helps you accept donations on your WP website with Robokassa (http://robokassa.ru/)!

== Description ==

* Author: [Malgin](https://github.com/Malgin)
* Project URL: <https://github.com/Malgin/dwr-wp-plugin>

Robokassa is a payment aggregator, which helps you accept payment via a wide variety of methods, including QIWI, WebMoney, Yandex.Money, Money@Mail.ru, with different Mobile Operators (Megafon, MTC), via terminals, and others!

With this plugin, you will be able to add a robokassa widget with a field for arbitrary amount of donation, or you can add a compact button to your pages/sidebars which will lead to the robokassa payment page with default donation value, which could be set on plugin settings page!

= Donations =
I do not accept donations, but I would be very gratitude if you will donate to [science populatization project](http://vertdider.com/pomoshh-proektu/ "Vert Dider") I work on as a volunteer.

= Bugs & Feature requests =
If you like my plugin, but find a bug in it, please create a bugreport on it's [official Github repository page](https://github.com/Malgin/dwr-wp-plugin/issues)
Also, if you have an idea how to improve the project further, please create feature requests [there, too](https://github.com/Malgin/dwr-wp-plugin/issues).

= Prerequisites =

* In order to use this plugin, you should be familiar with Robokassa system. You can read about it on [Robokassa official website](http://robokassa.ru/) (ru).
* This plugin _currently_ works only if Permalink Settings changed from Default.

= Shortcodes =
This plugin supports one shortcode: **[dwr_payment_widget]**. Inserting just this shortcode in an article, or on a page, will result in a widget with a field for arbitrary donation to appear on the page.

In order to insert **compact widget button**, you should add an empty 'compact' parameter to the shortcode, like this: [dwr_payment_widget compact].

**Warning!** If required (which are all) options are not set in the plugin settings page, a warning message will be displayed instead of a widget.

== Installation ==
You need to follow these FIVE (*one of two* at the end is optional) simple steps:

1. Download a plugin and copy it to 'site-root-dir/wp-content/plugins/donate-with-robokassa' folder.
2. In admin panel of the site, activate the plugin (You can do it under "Plugins -> Installed Plugins" menu).
3. Go to Settings -> Donate With Robokassa (DWR) page and fill in all the required fields (more details on this here).
4. Add [dwr_payment_widget] shortcode anywhere on the website where you would like to see robokassa donation widget.
5. (Optional) Create two pages, one of which will inform your users about the success of the operation, and probably, thank them for the donation, and other will inform them that operation has failed. Make their URLs nice and informative (you will pass these URLs in Robokassa admin panel as Success URL and Fail URL, both with GET method).
6. (Optional) Instead of creating separate pages, you could just set Success URL anf Fail URL to point to your websire homepage. But this is bit rude.

That's it! You're all set up.

== Screenshots ==

1. Robokassa widget with a field for arbitrary amount of donation.
2. Compact button.

== Changelog ==

= 1.0.0 =
* First public release of the plugin