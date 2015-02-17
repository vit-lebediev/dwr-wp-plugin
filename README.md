# Donate With Robokassa (DWR) Wordpress Plugin
Donate With Robokassa WordPress plugin helps you accept donations on your WP website with [Robokassa](http://robokassa.ru "Title")!

## How the plugin works
Warning! This plugin _currently_ works only if Permalink Settings changed from Default.

## How to start accepting donations
You need to follow these FIVE simple steps:

1. Download a plugin and copy it to 'site-root-dir/wp-content/plugins/donate-with-robokassa' folder
2. In admin panel of the site, activate the plugin
3. Go to Settings->Donate With Robokassa(DWR) page and fill in all requried fields
4. Add [dwr_payment_widget] shortcode anywhere on the website where you would like to see robokassa donation widget.
5. Create two pages, each of which will inform your users about the result of the operation, and probably, thank them for
   the donation. Make their URLs nice and informative (you will pass these URLs in Robokassa admin panel as Success URL and Fail URL,
   both with GET method).

That's it! You're all set up.


## Shortcodes

## Localization
The plugin is localized for English and Russian languages.

The plugin will not delete it's DataBase  table ('dwr_donations') on deactivation, due the possibility of loosing all donations history,
and, which is worse, collisions of invId with robokassa.
There's a checkbox on the parameters page of the plugin to force delete the table on deactivation.
