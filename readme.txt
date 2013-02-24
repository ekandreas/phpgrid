=== phpgrid ===
Contributors: EkAndreas
Tags: phpgrid, datatable, frontend, ajax, plugin, database, table, frontend, datagrid, mysql, mssql, postgress, shortcode
Requires at least: 3.5
Tested up to: 3.5.1
Stable tag: 0.5.2

Expose database table with shortcodes and phpgrid.org.

== Description ==

This plugin implements the phpgrid control from phpgrid.org.
With this you can expose any databas table or custom data as arrays to the frontend of your WordPress pages and posts.

You will need the free or paid version of [phpgrid](http://www.phpgrid.org).

Some of the features are:
* Sorting
* Add, delete, create data
* Pagination
* Custom output format to data as images, colors or whatever you want.
* Themes
* Connection to mysql, postgress, mssql or arrays
* Export to PDF or Excel
* Master and detail grids
* ...
Read more about all the features to phpgrid [here](http://www.phpgrid.org/features/)!

We are currently using this plugin as a base component to other plugin development so it will be extended with more advanced functions.

Join our [fb-page](https://www.facebook.com/pages/Phpgrid-for-WP/486409724756060) for support and discussions!

If you are a programmer:
Please, read more at GitHub repository: [phpgrid](https://github.com/EkAndreas/phpgrid "phpgrid")

== Installation ==
1. Place the code inside the plugin folder as usual installation of WordPress plugins. The folder should be named "phpgrid".

2. Download the free (or your paid) -version of phpgrid.org and place the lib folder under the plugin folder! Due to license rules we do not have the rights to provide you with the component.

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

== Screenshots ==
1. Shortcode inside your post html editor.

2. Example of exposed table \"wp_options\".

3. Supporting hooks and filters

4. Implementation example, wp_options

== Changelog ==
= 0.5.2 =
* sql connection with filter 'phpgrid_connection', read more at Github!

= 0.5.1 =
* mysql-connection supported with hook

= 0.5 =
* Initial