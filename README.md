# dwr-wp-plugin
Donate With Robokassa WordPress plugin helps you accept donations on your WP website with robokassa!

The plugin will not delete it's DataBase  table ('dwr_donations') on deactivation, due the possibility of loosing all donations history,
and, which is worse, collisions of invId with robokassa.
There's a checkbox on the parameters page of the plugin to force delete the table on deactivation.
