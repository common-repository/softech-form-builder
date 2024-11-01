<?php 
/**
 * Plugin Name: Softech Form Builder
 * Plugin URI: https://softechure.com/
 * Description: Make a easy form by simple steps
 * Version: 1.0.1
 * Author:      Softechure
 * Author URI:  https://softechure.com/
 * Text Domain: softech-form-builder
 * Domain Path: /languages
 * License:     GPLv2
 
 Softech Form Builder is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 2 of the License, or
 any later version.
 
 Softech Form Builder is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.
 
 You should have received a copy of the GNU General Public License
 along with Softech Form Builder. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define( 'SOFTECH_FORM_BUILDER_VERSION', '1.0.1' );
define( 'SOFTECH_FORM_BUILDER_MINIMUM_WP_VERSION', '4.0' );
define( 'SOFTECH_FORM_BUILDER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


if ( ! version_compare( PHP_VERSION, '5.4', '>=' ) ) 
{
  add_action( 'admin_notices', 'softech_form_builder_fail_php_version' );
} 
elseif ( ! version_compare( get_bloginfo( 'version' ), '4.0', '>=' ) ) 
{
    add_action( 'admin_notices', 'softech_form_builder_fail_wp_version' );
} 
else 
{

function softech_form_builder_textdomain() 
{
    // Set filter for plugin's languages directory
    $lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';

    // Load the translations
    load_plugin_textdomain( 'softech-form-builder', false, $lang_dir );
}
add_action( 'init', 'softech_form_builder_textdomain' );


require_once(dirname(__FILE__).'/list-table.php');
require_once(dirname(__FILE__).'/admin/add-new.php');
require_once(dirname(__FILE__).'/admin/add-shortcode.php');
require_once(dirname(__FILE__).'/help.php');
require_once(dirname(__FILE__).'/admin/sfb-load.php');
require_once(dirname(__FILE__).'/admin/sfb-save.php');
require_once(dirname(__FILE__).'/admin/sfb-shortcode-load.php');



/* ======= Register Plugin js. =========== */
function load_softech_form_builder_js() 
{
    wp_register_script( 'softech-form-builder', plugin_dir_url(__FILE__) . 'js/sfb-builder.js', '', '', false );
    wp_register_script( 'softech-form-builder-html-generator', plugin_dir_url(__FILE__) . 'js/sfb-html-generator.js', '', '', false );
    wp_register_script( 'softech-form-validate', plugin_dir_url(__FILE__) . 'js/jquery.validate.min.js', '', '', false );
    wp_register_script( 'softech-form-tether', plugin_dir_url(__FILE__) . 'js/tether.min.js', '', '', false );
    wp_register_script( 'softech-form-bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', '', '', false );
      wp_enqueue_script('jquery');// Include Wordpress Jquery 
      wp_enqueue_script ('jquery-ui-sortable');// Include Wordpress Jquery Ui
    wp_enqueue_script('softech-form-builder');
    wp_localize_script( 'softech-form-builder', 'ajax_form_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'ajax_nonce' => wp_create_nonce('check_softech_form')
    ));
    wp_enqueue_script('softech-form-builder-html-generator');
    wp_localize_script( 'softech-form-builder-html-generator', 'ajax_form_front_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));
    wp_enqueue_script('softech-form-tether');
    wp_enqueue_script('softech-form-bootstrap');
    wp_enqueue_script('softech-form-validate');
}
add_action( 'admin_enqueue_scripts', 'load_softech_form_builder_js' ); // It load the js file in admin area
add_action( 'wp_enqueue_scripts', 'load_softech_form_builder_js' );


/* ======= Register Plugin style sheet. =========== */
function load_softech_form_builder_style() 
{
    wp_register_style( 'softech-form-style', plugin_dir_url(__FILE__) . 'css/style.css', false, '1.0' );
    wp_register_style( 'softech-form-bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', false, '1.0' );
    wp_enqueue_style('softech-form-style');
    wp_enqueue_style('softech-form-bootstrap');
}
add_action( 'admin_enqueue_scripts', 'load_softech_form_builder_style' );  // It load the style file in admin area
add_action( 'wp_enqueue_scripts', 'load_softech_form_builder_style' );


/* ======= Register the Softech Form Builder Menu =========== */

function softech_form_builder_menu_register()
{
    global $softech_form_screen_hook;
    $softech_form_screen_hook = add_menu_page( __('Softech Form Builder','softech-form-builder'),       //Page Title
                  __('Softech Form Builder','softech-form-builder'),        //Menu Title
                  'manage_options', 
                  'softech-form-builder-list',               //Menu Slug
                  'softech_form_builder_list',           //Menu Page
                  'dashicons-editor-table', //Menu Icon
                  6
    );

    add_submenu_page( 'softech-form-builder-list',            //Parent Menu Slug
                      __('Softech Forms','softech-form-builder'),                //Page Title
                      __('Softech Forms','softech-form-builder'),                //SubMenu Title
                      'manage_options', 
                      'softech-form-builder-list',       //SubMenu Slug
                      'softech_form_builder_list'   //SubMenu Page
    );

    add_submenu_page( 'softech-form-builder-list',            //Parent Menu Slug
                      __('Create Form','softech-form-builder'),                //Page Title
                      __('Create Form','softech-form-builder'),              //SubMenu Title
                      'manage_options', 
                      'softech-new-form',       //SubMenu Slug
                      'softech_wp_form_page_handler'   //SubMenu Page
    );
    add_submenu_page( 'softech-form-builder-list',            //Parent Menu Slug
                      __('Get Help','softech-form-builder'),                //Page Title
                      __('Get Help','softech-form-builder'),              //SubMenu Title
                      'manage_options', 
                      'softech-form-help',       //SubMenu Slug
                      'softech_form_help'   //SubMenu Page
    );
    //add_action("load-".$softech_form_screen_hook, "softech_form_builder_screen_option_list");
}
add_action( 'admin_menu', 'softech_form_builder_menu_register' );


/* ======= Create The DataBase On Plugin Activation=========== */

global $softech_forms_db_version;
$softech_forms_db_version = '1.0.1'; // version changed from 1.0 to 1.1

function softech_forms_install()
{
    global $wpdb;
    global $softech_forms_db_version;

    $table_name = $wpdb->prefix . 'softech_forms'; // do not forget about tables prefix
    $sql = "CREATE TABLE " . $table_name . " (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        shortcode varchar(100) NOT NULL,
        form_structure text NOT NULL,
        form_mail_subject varchar(255) NOT NULL,
        form_mail_to varchar(255) NOT NULL,
        form_mail_cc text NOT NULL,
        form_mail_from varchar(255) NOT NULL,
        date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // save current database version for later use (on upgrade)
    add_option('softech_forms_db_version', $softech_forms_db_version);

    $installed_ver = get_option('softech_forms_db_version');
    if ($installed_ver != $softech_forms_db_version) 
    {
        $sql = "CREATE TABLE " . $table_name . " (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        shortcode varchar(100) NOT NULL,
        form_structure text NOT NULL,
        form_mail_subject varchar(255) NOT NULL,
        form_mail_to varchar(255) NOT NULL,
        form_mail_cc text NOT NULL,
        form_mail_from varchar(255) NOT NULL,
        date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        // notice that we are updating option, rather than adding it
        update_option('softech_forms_db_version', $softech_forms_db_version);
    }

}
register_activation_hook(__FILE__, 'softech_forms_install');

function softech_forms_update_db_check()
{
    global $softech_forms_db_version;
    if (get_site_option('softech_forms_db_version') != $softech_forms_db_version) 
    {
        softech_forms_install();
    }
}
add_action('plugins_loaded', 'softech_forms_update_db_check');

register_deactivation_hook( __FILE__, 'softech_form_remove_database' );
function softech_form_remove_database() 
{
     global $wpdb;
     $table_name = $wpdb->prefix . 'softech_forms';
     $sql = "DROP TABLE IF EXISTS $table_name";
     $wpdb->query($sql);
     delete_option("softech_forms_db_version");
}

}

/**
 * Softech Form Builder admin notice for minimum PHP version.
 * Warning when the site doesn't have the minimum required PHP version.
 */
function softech_form_builder_fail_php_version() 
{
    /* translators: %s: PHP version */
    $message = sprintf( esc_html__( 'Softech Form Builder requires PHP version %s+, plugin is currently NOT RUNNING.', 'softech-form-builder' ), '5.4' );
    $html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
    echo wp_kses_post( $html_message );
}

/**
 * Softech Form Builder admin notice for minimum WordPress version.
 * Warning when the site doesn't have the minimum required WordPress version.
 */
function softech_form_builder_fail_wp_version() 
{
    /* translators: %s: WordPress version */
    $message = sprintf( esc_html__( 'Softech Form Builder requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'softech-form-builder' ), '4.6' );
    $html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
    echo wp_kses_post( $html_message );
}
?>