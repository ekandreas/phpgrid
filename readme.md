# phpgrid

This WordPress plugin is copied from Abu Ghufran and improved by Andreas Ek.

We have just started with this plugin development. At a start just showing an example of the php grid control / free version.
The shortcode shows the table wp_users from shortcode to demonstrate the grid control in action.

For more information about the php grid control, go to [www.phpgrid.org](www.phpgrid.org)

## Installation
Place the code inside the plugin folder as usual installation of WordPress plugins.
The folder should be named "phpgrid".

## Configuration
* Really important that you put a custom action 'phpgrid_header' in your theme "header.php" -file. Eg,
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

* Place a shortcode [phpgrid] in your post or page HTML-editor and the grid with wp_users should be listed in the frontend.

## Actions in WordPress
You could instead of shortcode use action to output the grid control, eg:
```php
<?php
// Outputs the phpgrid control
do_action( 'phpgrid_output' );
?>
```

## Filters in WordPress

### Options
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

### Table
Override the grid control table source with the filter 'phpgrid_table', eg:
```php
<?php
function my_phpgrid_table(){
    return 'wp_posts';
}
add_filter( 'phpgrid_table', 'my_phpgrid_table' );
?>
```

### Columns
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

### Columns
Override the grid control id name with the filter 'phpgrid_name', eg:
```php
<?php
function my_phpgrid_name(){
    return 'my_grid_id_name';
}
add_filter( 'phpgrid_name', 'my_phpgrid_name' );
?>
```

## Contact
Please feel free to contact me at Twitter [@EkAndreas](https://twitter.com/ekandreas) for further questions and feedback!