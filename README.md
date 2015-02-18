# Donate With Robokassa (DWR) Wordpress Plugin
Donate With Robokassa WordPress plugin helps you accept donations on your WP website with [Robokassa](http://robokassa.ru "Title")!

With this plugin, you will be able to add a robokassa widget with a field for arbitrary amount of donation, like this one:

![image](https://cloud.githubusercontent.com/assets/1384973/6256310/cbb23562-b7bf-11e4-9868-532b18fe5154.png)

Or you can add a compact button to your pages/sidebars which will lead to the robokassa payment page with default donation
value, which could be set on plugin settings page!

![image](https://cloud.githubusercontent.com/assets/1384973/6256359/2cb64ca4-b7c0-11e4-91ad-f4efc222d127.png)

## How the plugin works
**Warning!** This plugin _currently_ works only if Permalink Settings changed from Default.

## How to start accepting donations
You need to follow these FIVE simple steps:

1. Download a plugin and copy it to 'site-root-dir/wp-content/plugins/donate-with-robokassa' folder
2. In admin panel of the site, activate the plugin (You can do it under "Plugins -> Installed Plugins" menu)
3. Go to Settings -> Donate With Robokassa (DWR) page and fill in all the required fields
4. Add [dwr_payment_widget] shortcode anywhere on the website where you would like to see robokassa donation widget.
5. (Optional) Create two pages, each of which will inform your users about the result of the operation, and probably, thank them for
   the donation. Make their URLs nice and informative (you will pass these URLs in Robokassa admin panel as Success URL and Fail URL,
   both with GET method).
6. (Optional) Instead of creating separate pages, you could just set Success URL anf Fail URL to point to your websire homepage. But this is bit rude.

That's it! You're all set up.


## Shortcodes
This plugin supports one shortcode: [dwr_payment_widget]. Inserting just this shortcode in an article, or on a page, will result in
a widget with arbitrary donation to appear on the page.
In order to insert compact widget button, you should add an empty 'compact' parameter to the shortcode, like this: [dwr_payment_widget compact]
**Warning!** If required (which are all) options are not set in the plugin settings page, a warning message will be displayed instead of a widget.

## Options

## Localization
The plugin is localized for English and Russian languages.

The plugin will not delete it's DataBase  table ('dwr_donations') on deactivation, due the possibility of loosing all donations history,
and, which is worse, collisions of invId with robokassa.
There's a checkbox on the parameters page of the plugin to force delete the table on deactivation.
