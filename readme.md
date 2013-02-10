# phpgrid

This WordPress plugin is copied from Abu Ghufran and improved by Andreas Ek.

We have just started with this plugin development. At a start just showing an example of the php grid control / free version.
The shortcode shows the table wp_users from shortcode to demonstrate the grid control in action.

For more information about the php grid control, go to [www.phpgrid.org](www.phpgrid.org)

## Installation
Place the code inside the plugin folder as usual installation of WordPress plugins.
The folder should be named "phpgrid".

## Configuration
**Important that you put a custom action 'phpgrid_header' in your theme "header.php" -file.** Eg,
```php
<?php
// This is the custom action needed
do_action( 'phpgrid_header' );
// End of custom action implementation
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
```

Place a shortcode [phpgrid] in your post or page HTML-editor and the grid with wp_users should be listed in the frontend.


## Actions in WordPress
You could instead of shortcode use action to output the grid control, eg:
```php
<?php
// Outputs the phpgrid control
do_action( 'phpgrid_output' );
?>
```
The phpgrid_output is where the grid control is visible to the visitors on page.

## Filters in WordPress

### Options
Options is used to customize the grid control in general.
Override the grid control options with the filter 'phpgrid_options', eg:
```php
<?php
function my_phpgrid_options(){
    $grid = array();
    $grid["caption"] = "My own phpgrid caption";
    $grid["multiselect"] = true;
    return $grid;
}
add_filter( 'phpgrid_output', 'my_phpgrid_options' );
?>
```
You can find more examples here: [Grid Options](http://www.phpgrid.org/docs/#grid-options)

### Table
Table is the data source.
**Note!** To use arrays you have to use the paid professional version of phpgrid control! Just replace the files under the 'lib' folder to upgrade.
Override the grid control table source with the filter 'phpgrid_table', eg:
```php
<?php
function my_phpgrid_table(){
    return 'wp_posts';
}
add_filter( 'phpgrid_table', 'my_phpgrid_table' );
?>
```
You can find more examples here: [Getting started](http://www.phpgrid.org/docs/#getting-started)

### Columns
Columns is used to define your own column settings.
Override the grid control column settings with the filter 'phpgrid_columns', eg:
```php
<?php
function my_phpgrid_columns(){
    $col = array();
    $col["title"] = 'My column name'; // caption of column
    $col["name"] = "name";
    $col["width"] = "10";
    $cols[] = $col;
    return $cols;
}
add_filter( 'phpgrid_columns', 'my_phpgrid_columns' );
?>
```
You can find more examples here: [Column Options](http://www.phpgrid.org/docs/#column-options)

### Name
The name or id of the control when rendered on page.
Override the grid control id name with the filter 'phpgrid_name', eg:
```php
<?php
function my_phpgrid_name(){
    return 'my_grid_id_name';
}
add_filter( 'phpgrid_name', 'my_phpgrid_name' );
?>
```
Default name is 'phpgrid1'.


## Contact
Please feel free to contact me at Twitter [@EkAndreas](https://twitter.com/ekandreas) for further questions and feedback!