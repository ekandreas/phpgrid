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

## Contact
Please feel free to contact me at Twitter [@EkAndreas](https://twitter.com/ekandreas) for further questions and feedback!