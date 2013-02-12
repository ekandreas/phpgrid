<?php
/*
Plugin Name: PHP Grid Control
Plugin URI: http://www.phpgrid.org/
Description: PHP Grid Control modified plugin from Abu Ghufran.
Author: EkAndreas
Version: 0.5
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

        // load core lib at template_redirect because we need the post data!
        add_action( "template_redirect", array( &$this, 'phpgrid_header' ) );

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
        global $post;

        //if (!is_page()) return;

        $grid_columns = array();
        $grid = array();

        // set database table for CRUD operations, override with filter 'phpgrid_table'.
        $table = '';

        // possible hook on custom sql connection - if not used standard wp database is used
        do_action( 'phpgrid_sql_connection' );

        // init the grid control
        $g = new jqgrid();

        // first, check if shortcode is used!
        $pattern = get_shortcode_regex();
        if (   preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
            && array_key_exists( 2, $matches )
            && in_array( 'phpgrid', $matches[2] ) )
        {

            $column_names = array();
            $column_titles = array();

            // loop through all attributes to check for the right one!
            foreach( $matches[3] as $attributes ){

                $table = $this->get_attribute( $attributes, 'table', $table );
                $column_names = $this->get_attribute( $attributes, 'column_names', $grid_columns );
                $column_titles = $this->get_attribute( $attributes, 'column_titles', $grid_columns );

            }


            if ( !is_array( $column_names ) ) {

                $cols = array();

                $colnames_arr = explode( ",", $column_names );
                $coltitles = explode( ",", $column_titles );

                foreach( $colnames_arr as $key => $column ){

                    $col = array();
                    $col["name"] = $column;

                    if ( $coltitles[$key] ) $col["title"] = $coltitles[$key]; // caption of column

                    $cols[] = $col;

                }

                $grid_columns = $cols;
            }

        }

        if ( isset( $_REQUEST['phpgrid_table'] ) ) $table = esc_attr( $_REQUEST['phpgrid_table'] );

        $table = apply_filters( 'phpgrid_table', $table );

        if ( empty( $table ) ) return;

        $g->table = $table;

        // set some standard options to grid. Override this with filter 'phpgrid_options'.
        $grid["caption"] = $table;
        $grid["multiselect"] = false;
        $grid["autowidth"] = true;

        // fetch if filter is used otherwise use standard options
        $grid = apply_filters( 'phpgrid_options', $grid );

        // now use ajax! this is a wp override!
        $grid["url"] = admin_url( 'admin-ajax.php' ) . '?action=phpgrid_data&phpgrid_table=' . $table;

        // set the options
        $g->set_options( $grid );

        // set actions to the grid
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

        // open actions for filters
        $actions = apply_filters( 'phpgrid_actions', $actions );
        $g->set_actions( $actions );

        // set columns with filter
        $g->set_columns( apply_filters( 'phpgrid_columns', $grid_columns ) );

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
        //wp_enqueue_script( 'jquery-ui-core' );

        $theme = apply_filters( 'phpgrid_theme', 'redmond' );
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

    function get_attribute( $all_attributes, $attribute, $default ){

        $result = $default;

        preg_match( '/' . $attribute . '="([^"]*)"/', $all_attributes, $attr );
        if ( !empty( $attr[1] ) ) {
            $result = $attr[1];
        }

        return $result;

    }
}