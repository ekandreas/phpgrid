<?php
/*
Plugin Name: PHP Grid Control
Plugin URI: http://www.phpgrid.org/
Description: PHP Grid Control modified plugin from Abu Ghufran.
Author: EkAndreas
Version: 0.1
Author URI: http://www.flowcom.se/
*/

//Important to place the including class available to usage inside theme and other plugins!
include_once( WP_PLUGIN_DIR . "/phpgrid/lib/inc/jqgrid_dist.php");

//Create an object instance of the class
$phpgrid_plugin = new PHPGrid_Plugin();

/**
 * The class puts the dependent scripts in the page loading and creates a hook for header.
 */
class PHPGrid_Plugin{

    private $global_output;

    /**
     * Activates actions
     */
    function __construct(){

        // load core lib
        add_action( "phpgrid_header", array( &$this, 'phpgrid_header' ) );

        // load js and css files
        add_action( "wp_enqueue_scripts", array( &$this, 'wp_enqueue_scripts' ) );

        // added short code for display position
        add_shortcode( "phpgrid", array( &$this, 'shortcode_phpgrid' ) );

        // add a filter for the output
        add_filter('phpgrid_output', array($this, 'phpgrid_output' ) );

        // ajax
        add_action('wp_ajax_phpgrid_data', array($this, 'phpgrid_data' ) );
        add_action('wp_ajax_nopriv_phpgrid_data', array($this, 'phpgrid_data' ) );
    }

    /**
     * This is the custom action, placed in header at your theme before any html-output!
     * To be continued: hooks and filters to perform different grids on different tables and datasources.
     */
    function phpgrid_header()
    {
        // don't really know why this could not be split into one for header and one for ajax...
        $this->phpgrid_data();
    }

    function phpgrid_data(){

        // set up DB
        $conn = mysql_connect( DB_HOST, DB_USER, DB_PASSWORD, true);
        mysql_select_db( DB_NAME );

        // set your db encoding -- for ascent chars (if required)
        mysql_query("SET NAMES 'utf8'");

        $g = new jqgrid();

        // now use ajax!
        $grid["url"] = admin_url('admin-ajax.php') . '?action=phpgrid_data';

        // set few params
        $grid["caption"] = "wp_users";
        $grid["multiselect"] = false;

        $g->set_options($grid);

        // set database table for CRUD operations
        $g->table = "wp_users";

        // subqueries are also supported now (v1.2)
        // $g->select_command = "select * from (select * from invheader) as o";

        // render grid
        $this->global_output = $g->render("wp_users");

    }


    /**
     * Register styles and scripts. The scripts are placed in the footer for compability issues.
     */
    function wp_enqueue_scripts()
    {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-core' );

        wp_register_style( 'phpgrid_theme', WP_PLUGIN_URL . '/phpgrid/lib/js/themes/redmond/jquery-ui.custom.css' );
        wp_enqueue_style( 'phpgrid_theme' );

        wp_register_style( 'jqgrid_css', WP_PLUGIN_URL . '/phpgrid/lib/js/jqgrid/css/ui.jqgrid.css' );
        wp_enqueue_style( 'jqgrid_css' );

        wp_register_script( 'jqgrid_localization', WP_PLUGIN_URL . '/phpgrid/lib/js/jqgrid/js/i18n/grid.locale-en.js', array('jquery'), false, true);
        wp_enqueue_script( 'jqgrid_localization' );

        wp_register_script( 'jqgrid', WP_PLUGIN_URL . '/phpgrid/lib/js/jqgrid/js/jquery.jqGrid.min.js', array('jquery'), false, true);
        wp_enqueue_script( 'jqgrid' );

        //wp_register_script( 'jqquery-ui-theme', WP_PLUGIN_URL . '/phpgrid/lib/js/themes/jquery-ui.custom.min.js', array('jquery'), false, true);
        //wp_enqueue_script( 'jqquery-ui-theme' );

    }

    /*
     * Output the shortcode
     */
    function shortcode_phpgrid( $content )
    {
        return $this->phpgrid_output();
    }

    /*
     * Output the shortcode
     */
    function phpgrid_output()
    {
        return $this->global_output;
    }

}