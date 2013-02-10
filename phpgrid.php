<?php
/*
Plugin Name: PHP Grid Control
Plugin URI: http://www.phpgrid.org/
Description: PHP Grid Control modified plugin from Abu Ghufran.
Author: EkAndreas
Version: 0.2
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

    private $phpgrid_output;

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

        // add an action for the output
        add_action('phpgrid_output', array($this, 'phpgrid_output' ) );

        // ajax
        add_action('wp_ajax_phpgrid_data', array($this, 'phpgrid_header' ) );
        add_action('wp_ajax_nopriv_phpgrid_data', array($this, 'phpgrid_header' ) );
    }

    /**
     * This is the custom action, placed in header at your theme before any html-output!
     * To be continued: hooks and filters to perform different grids on different tables and datasources.
     */
    function phpgrid_header()
    {

        // possible hook on custom sql connection - if not used standard wp databas is used
        do_action( 'phpgrid_sql_connection' );

        // init the grid control
        $g = new jqgrid();

        // set some standard options to grid. Override this with filter 'phpgrid_options'.
        $grid["caption"] = "wp_users";
        $grid["multiselect"] = false;

        // fetch if filter is used otherwise use standard options
        $grid = apply_filters( 'phpgrid_options', $grid );

        // now use ajax! this is a wp override!
        $grid["url"] = admin_url( 'admin-ajax.php' ) . '?action=phpgrid_data';

        // set the options
        $g->set_options( $grid );

        // set database table for CRUD operations, override with filter 'phpgrid_table'.
        $table = 'wp_users';
        $g->table = apply_filters( 'phpgrid_table', $table );

        // set columns, override with filter 'phpgrid_columns'.
        $columns = array();
        $g->set_columns( apply_filters( 'phpgrid_columns', $columns ) );

        // subqueries are also supported now (v1.2)
        // $g->select_command = "select * from (select * from invheader) as o";

        // render grid, possible to override the name with filter 'phpgrid_name'.
        $this->phpgrid_output = $g->render( apply_filters( 'phpgrid_name', 'phpgrid1' ) );

    }

    /**
     * Register styles and scripts. The scripts are placed in the footer for compability issues.
     */
    function wp_enqueue_scripts()
    {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-core' );

        $theme = apply_filters( 'phpgrid_theme', 'smoothness' );
        $theme_script = apply_filters( 'phpgrid_theme_script', WP_PLUGIN_URL . '/phpgrid/lib/js/themes/' . $theme . '/jquery-ui.custom.css' );
        wp_register_style( 'phpgrid_theme', $theme_script );
        wp_enqueue_style( 'phpgrid_theme' );

        wp_register_style( 'jqgrid_css', WP_PLUGIN_URL . '/phpgrid/lib/js/jqgrid/css/ui.jqgrid.css' );
        wp_enqueue_style( 'jqgrid_css' );

        $lang = apply_filters( 'phpgrid_lang', 'en' );
        $localization = apply_filters( 'phpgrid_lang_script', WP_PLUGIN_URL . '/phpgrid/lib/js/jqgrid/js/i18n/grid.locale-' . $lang . '.js' );
        wp_register_script( 'jqgrid_localization', $localization, array('jquery'), false, true);
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
        return $this->phpgrid_output;
    }

    /*
     * Output the shortcode
     */
    function phpgrid_output()
    {
        echo $this->phpgrid_output;
    }

}