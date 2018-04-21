<?php
/**
 * @package noo-organici-library
 */
/*
Plugin Name: Noo Organici Library
Plugin URI: http://nootheme.com/
Description: This is plugin for NooTheme. This plugin allows you to create post types, taxonomies, Shortcode . . .
Version: 1.8.7
Author: NooTheme
Author URI: http://nootheme.com/
License: GPLv2 or later
*/


/**
 * This is the Noo Posttype loader class.
 *
 * @package   Noo_Posttype
 * @author    nootheme (http:://nootheme.com)
 * @copyright Copyright (c) 2015, NooTheme
 */

if ( !class_exists('Noo_Organici_Library') ):

    class Noo_Organici_Library{

        /*
         * This method loads other methods of the class.
         */
        public function __construct(){


            /*load all nootheme*/
            $this -> load_nootheme();

            /*auto update version*/
            $this->load_check_version();

            /* load languages */
            $this -> load_languages();
        }

        /*
         * Load the languages before everything else.
         */
        private function load_languages(){
            add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        }

        /*
         * Load the text domain.
         */
        public function load_textdomain(){

            load_plugin_textdomain(  'noo', false, plugin_basename( dirname( __FILE__ ) ).'/languages' );
        }

        /*
         * Load Nootheme on the 'after_setup_theme' action. Then filters will
         */
        public function load_nootheme(){

            $this -> constants();

            $this -> admin_includes();
        }

        /*
         * Load Nootheme on the 'after_setup_theme' action. Then filters will
         */
        public function load_check_version(){

            if( !class_exists('Noo_Check_Version_Child') ) {
                require_once( NOO_PLUGIN_SERVER_PATH.'/admin/noo-check-version-child.php' );
            }

            $check_version = new Noo_Check_Version_Child(
                'noo-organici-library',
                'Noo Organici Library',
                'noo-organici',
                'http://update.nootheme.com/api/license-manager/v1',
                'plugin',
                __FILE__
            );
        }

        /**
         * Constants
         */
        private function constants(){

            if( !defined( 'NOO_PLUGIN_PATH' ) ) define('NOO_PLUGIN_PATH', plugin_dir_url( __FILE__ ));

            if( !defined( 'NOO_PLUGIN_ASSETS_URI' ) ) define('NOO_PLUGIN_ASSETS_URI', plugin_dir_url( __FILE__ ) . 'assets');

            if( !defined( 'NOO_PLUGIN_SERVER_PATH' ) ) define('NOO_PLUGIN_SERVER_PATH',dirname( __FILE__ ) );
        }

        /*
         * Require file
         */
        private function  admin_includes(){
             require_once NOO_PLUGIN_SERVER_PATH . '/admin/importer/noo-setup-install.php';
            require_once NOO_PLUGIN_SERVER_PATH . '/admin/post-type/function-init.php';
            require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/vc_init.php';
        }


    }
    $oj_nooplugin = new Noo_Organici_Library();

endif;

// 1.2. Add NOO-Customizer Menu
function noo_add_customizer_menu() {
    $customizer_icon = 'dashicons-admin-customizer';

    add_menu_page( esc_html__( 'Customizer', 'noo' ), esc_html__( 'Customizer', 'noo' ), 'edit_theme_options', 'customize.php', null, $customizer_icon, 61 );
    add_submenu_page( 'options.php', '', '', 'edit_theme_options', 'export_settings', 'noo_organici_customizer_export_theme_settings' );
}

add_action( 'admin_menu', 'noo_add_customizer_menu' );

require_once dirname( __FILE__ ) . '/admin/smk-sidebar-generator/smk-sidebar-generator.php';
require_once dirname( __FILE__ ) . '/admin/mailchimp/MCAPI.class.php';
require_once dirname( __FILE__ ) . '/admin/twitter/twitteroauth.php';