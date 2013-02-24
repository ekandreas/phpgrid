# phpgrid

This WordPress plugin is copied from Abu Ghufran and improved by Andreas Ek.

We have just started with this plugin development. At a start just showing an example of the php grid control / free version.

For more information about the php grid control, go to [www.phpgrid.org](www.phpgrid.org)

Please, join our [fb-page](https://www.facebook.com/pages/Phpgrid-for-WP/486409724756060) for support and discussions!

![Shortcode](https://raw.github.com/EkAndreas/phpgrid/master/screenshot-4.jpg)


## Installation
1. Place the code inside the plugin folder as usual installation of WordPress plugins. The folder should be named "phpgrid".

2. Download the free (or your paid) -version of phpgrid.org and place the lib folder under the plugin folder! Due to license rules we do not have the rights to provide you with the component.

## Configuration
Place a shortcode [phpgrid table="wp_posts"] in your post or page HTML-editor and the grid with posts should be listed in the frontend.

## Shortcode
You have to use the attribute 'table' to assign an existing database table. Eg,
```text
[phpgrid table="wp_options"]
```

### Optional shortcode attributes
Set columns use with the attribute 'columns' as in this example:
```text
[phpgrid table="wp_options" columns="option_name,option_value"]
```

If you like to set column titles use the attribute 'titles', eg:
```text
[phpgrid table="wp_options" columns="option_name,option_value" titles="Name,Value"]
```

Set the caption to the grid with the attribute 'caption', eg:
```text
[phpgrid table="wp_options" caption="OPTIONS" columns="option_name,option_value" titles="Name,Value"]
```

Enable expoprt to excel via parameter 'export', eg:
```text
[phpgrid table="wp_options" export="true"]
```

Change localization with the parameter 'language', eg:
```text
[phpgrid table="wp_options" language="sv"]
```
The example above will show functions for a swedish grid.
Supported languages: [Localization](http://www.phpgrid.org/docs/#localization)


![Shortcode](https://raw.github.com/EkAndreas/phpgrid/master/screenshot-1.jpg)

![phpgrid](https://raw.github.com/EkAndreas/phpgrid/master/screenshot-2.jpg)


In the next version of this plugin we will provide "orderby" and "where" attributes...


## Contact
Please feel free to contact me at Twitter [@EkAndreas](https://twitter.com/ekandreas) for further questions and feedback!

## Advanced usage
If you want to use the control as integrated with your plugin development, use actions and filters as below.

![filters](https://raw.github.com/EkAndreas/phpgrid/master/screenshot-3.jpg)

### Actions in WordPress
You could, instead of shortcode, use action to output the grid control, eg:
```php
<?php
// Outputs the phpgrid control
do_action( 'phpgrid_output' );
?>
```
The phpgrid_output is where the grid control is visible to the visitors on page.

### Filters in WordPress

Place the filters in your theme or plugin. Eg, function.php

If you use several grids then [create a switch](#switch-example-for-several-grids) that makes the right values to your grid in the right situation!


#### Themes
Provide the control with another look via different jquery-ui roller themes!

There are two different filters to use for managing the theme; 'phpgrid_theme' for just changing to one of the provided themes and 'phpgrid_theme_script' to change the loaded jquery-ui roller theme file.

##### phpgrid_theme
You could set the theme name via the 'phpgrid_theme' filter, eg:
```php
<?php
function my_phpgrid_theme(){
    return 'smoothness';
}
add_filter( 'phpgrid_theme', 'my_phpgrid_theme' );
?>
```
Standard is 'redmond'. You can find more examples here: [Grid Options](http://www.phpgrid.org/docs/#grid-options)

##### phpgrid_theme_script
You could set the theme script via the 'phpgrid_theme_script' filter, eg:
```php
<?php
function my_phpgrid_theme_script(){
    return get_stylesheet_directory_uri() . '/css/my-very-own-roller-script.js';
}
add_filter( 'phpgrid_theme_script', 'my_phpgrid_theme_script' );
?>
```

#### Options
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

#### Actions
Actions is used to set general features to the grid control.

Override the grid control actions with the filter 'phpgrid_actions', eg:
```php
<?php
function my_phpgrid_actions(){
    $actions = array(
        "add"               => true, // now possible to add new records
        "edit"              => true, // now possible to edit records
        "delete"            => false,
        "rowactions"        => false,
        "export"            => true,
        "autofilter"        => true,
        "search"            => "simple",
        "inlineadd"         => false,
        "showhidecolumns"   => false
    );
    return $actions;
}
add_filter( 'phpgrid_actions', 'my_phpgrid_actions' );
?>
```
You can find more examples under **Grid Actions** below Grid Options: [Grid Options](http://www.phpgrid.org/docs/#grid-options)

Standard actions are:
```php
$actions = array(
    "add"               => false,
    "edit"              => false,
    "delete"            => false,
    "rowactions"        => false,
    "export"            => true,
    "autofilter"        => true,
    "search"            => "simple",
    "inlineadd"         => false,
    "showhidecolumns"   => false
);
```

#### Table
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

#### Columns
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

#### Name
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

#### Localization
Provide the control with localization support!

There are two different filters to use for managing the localization; 'phpgrid_lang' for just changing to one of the provided languages and 'phpgrid_lang_script' to change the loaded localization script.

##### phpgrid_lang
You could set the theme name via the 'phpgrid_lang' filter, eg:
```php
<?php
function my_phpgrid_lang(){
    return 'sv'; // for swedish language in the control.
}
add_filter( 'phpgrid_lang', 'my_phpgrid_lang' );
?>
```

##### phpgrid_lang_script
You could set the theme script via the 'phpgrid_lang_script' filter, eg:
```php
<?php
function my_phpgrid_lang_script(){
    return get_stylesheet_directory_uri() . '/js/my-very-own-lang-script.js';
}
add_filter( 'phpgrid_lang_script', 'my_phpgrid_lang_script' );
?>
```
You can find more examples here: [Localization](http://www.phpgrid.org/docs/#localization)

##### Set another sql connection
(New in version 0.5.2)

Change the database connection for the grid via hook "phpgrid_connection", eg:
```php
<?php
// add a filter and connect it to your function
add_filter( 'phpgrid_table', 'my_phpgrid_table' );

// return the database and table you like to connect to
function my_phpgrid_table(){
    return 'mydatabase.mytablename';
}

// add filter for the grids connection filter
add_filter( 'phpgrid_connection', 'my_phpgrid_connection' );

// return an array with the connection data
function my_phpgrid_connection(){
    $db_conf = array();
    $db_conf["type"]        = 'mysql'; // mysql,oci8(for oracle),mssql,postgres,sybase
    $db_conf["server"]      = 'localhost';
    $db_conf["user"]        = 'root';
    $db_conf["password"]    = 'pass';
    $db_conf["database"]    = 'database';
    return $db_conf;
}
?>
```
Read more about ADODB-connections at [phpgrid.org](http://www.phpgrid.org/docs/#adodb)

##### Switch example for several grids
If you are using the grid in several places with different lookups you could implement a switch. This is how I solved it in my WordPress example:
```php
// add action to control on which page template we use at the moment
// note the prio before 10!
add_action( 'template_redirect', 'my_phpgrid_switch', 9 );

// our switch function to decide table and connection
function my_phpgrid_switch(){

    // check if the template on this page contains our file name
    if ( strstr( get_page_template(), 'phpgrid-connection.php' ) ){

        // add a filter and connect it to your function
        add_filter( 'phpgrid_table', 'my_phpgrid_table_external' );

        // add filter for the grids connection filter
        add_filter( 'phpgrid_connection', 'my_phpgrid_connection' );

    }
    else{

        // add filter for the grids connection filter
        add_filter( 'phpgrid_table', 'my_phpgrid_table_normal' );

    }

}

// return the table name
function my_phpgrid_table_normal(){
    return 'wp_posts';
}

// return the database and table you like to connect to
function my_phpgrid_table_external(){
    return 'mydatabasename.mytablename';
}


// return an array with the connection data
function my_phpgrid_connection(){
    $db_conf = array();
    $db_conf["type"]        = 'mysql'; // mysql,oci8(for oracle),mssql,postgres,sybase
    $db_conf["server"]      = 'localhost';
    $db_conf["user"]        = 'root';
    $db_conf["password"]    = 'pass';
    $db_conf["database"]    = 'my-database-name';
    return $db_conf;
}
?>
```


Please, join our [fb-page](https://www.facebook.com/pages/Phpgrid-for-WP/486409724756060) for support and discussions!
