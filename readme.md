# phpgrid

This WordPress plugin is copied from Abu Ghufran and improved by Andreas Ek.

We have just started with this plugin development and it should improve from just one shortcode implementation to something bigger :-)

## Install
*Place the code inside the plugin folder as usual installation of WordPress plugins.
The folder should be named "phpgrid".

## Configuration
* Really important that you put a custom action 'phpgrid_header' in your theme "header.php" -file. Eg,
```php
<?php

    do_action( 'phpgrid_header' );

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

* Now place a shortcode [phpgrid] in your post or page HTML-editor and the grid with wp_users should be listed in the frontend.

## Contact
Please feel free to contact me at Twitter @EkAndreas for further questions and feedback!