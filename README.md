# Donate With Robokassa (DWR) Wordpress Plugin
Donate With Robokassa WordPress plugin helps you accept donations on your WP website with [Robokassa](http://robokassa.ru "Robokassa Website")!

Robokassa is a payment aggregator, which helps you accept payment via a wide variety of methods, including WebMoney, Yandex.Money, Money@Mail.ru,
with different Mobile Operators (Megafon, MTC), via terminals, and others!

With this plugin, you will be able to add a robokassa widget with a field for arbitrary amount of donation, like this one:

![image](https://cloud.githubusercontent.com/assets/1384973/6256310/cbb23562-b7bf-11e4-9868-532b18fe5154.png)

Or you can add a compact button to your pages/sidebars which will lead to the robokassa payment page with default donation
value, which could be set on plugin settings page!

![image](https://cloud.githubusercontent.com/assets/1384973/6256359/2cb64ca4-b7c0-11e4-91ad-f4efc222d127.png)

## Prerequisites
* In order to use this plugin, you should be familiar with Robokassa system. You can read about it on [Robokassa official website](http://robokassa.ru "Robokassa Website") (ru).
* This plugin _currently_ works only if Permalink Settings changed from Default.

## How to start accepting donations
You need to follow these FIVE (**one of two** at the end is optional) simple steps:

1. Download a plugin and copy it to 'site-root-dir/wp-content/plugins/donate-with-robokassa' folder.
2. In admin panel of the site, activate the plugin (You can do it under "Plugins -> Installed Plugins" menu).
3. Go to Settings -> Donate With Robokassa (DWR) page and fill in all the required fields (more details on this [here](https://github.com/Malgin/dwr-wp-plugin#donate-with-robokassa-dwr-settings-page)).
4. Add **[dwr_payment_widget]** shortcode anywhere on the website where you would like to see robokassa donation widget.
5. (Optional) Create two pages, each of which will inform your users about the result of the operation, and probably, thank them for
   the donation. Make their URLs nice and informative (you will pass these URLs in Robokassa admin panel as Success URL and Fail URL,
   both with GET method).
6. (Optional) Instead of creating separate pages, you could just set Success URL anf Fail URL to point to your websire homepage. But this is bit rude.

That's it! You're all set up.

## Shortcodes
This plugin supports one shortcode: **[dwr_payment_widget]**. Inserting just this shortcode in an article, or on a page, will result in
a widget with a field for arbitrary donation to appear on the page.

In order to insert **compact widget button**, you should add an empty 'compact' parameter to the shortcode, like this: **[dwr_payment_widget compact]**.

**Warning!** If required (which are all) options are not set in the plugin settings page, a warning message will be displayed instead of a widget.

## Settings
There's two settings sections for the plugin:

* Settings -> Donate With Robokassa (DWR)
* Settings -> DWR Statistics

#### Donate With Robokassa (DWR) Settings page
On this page, there's a list of options, required to be set before a plugin could operate.

* Robokassa Result URL.  
This option describes a part of Robokassa Result URL (a parameter in Robokassa shop settings), which will be attached to your website hostname.
It is recommended to leave this option with a default value. Change it only if you understand what are you doing.  
_Example_: Your website is http://myonlineblog.com/. If 'Robokassa Result URL' setting will be default ('robokassa_result'), then you should
set Result URL on Robokassa shop settings page to **http://myonlineblog.com/robokassa_result**.

* Robokassa Result URL Method  
This should be the same, as on Robokassa shop settings page for Result URL.

* Merchant Login  
This is a so called **shop identifier**. You can find it on the settings page of your shop in Robokassa shop admin panel.

* Merchant Password #1 & Merchant Password #2  
Should be the same as the values you set in shop settings.

* Default donation amount  
The default amount set to the widget with a field for specifying donation, and default amount which will be used for a compact button.

* Robokassa transaction description  
The description of a Robokassa shop transaction. Will be displayed in the list of operations in admin panel of the shop.

* Force delete tables  
If this checkbox set, on deactivation of a plugin a table with all transactions will be deleted.  
**Warning!** A table holds all transaction history, and if lost, all statistics will be lost too! (Though transaction history could be
viewed in the admin panel of the shop)

#### DWR Statistics
Currently, this page only displays a list of last 100 donations with a very basic statistics. I _plan_ to work on this part more, and make 
statistics more representative.

## Localization
The plugin is localized for English and Russian languages.

**One again**. The plugin will not delete it's DataBase table ('dwr_donations') on deactivation, due the possibility of loosing all donations history.  
This mean that you can deactivate a plugin, and then re-activate it, and all previous statistics will be available.  
There's a checkbox on the parameters page of the plugin to force delete the table on deactivation.
