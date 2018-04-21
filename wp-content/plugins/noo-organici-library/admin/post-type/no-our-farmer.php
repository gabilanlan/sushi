<?php
/**
 * Register NOO farmer.
 * This file register Item and Category for NOO farmer.
 *
 * @package    NOO Framework
 * @subpackage NOO farmer
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2015, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */

if( !class_exists('Noo_Our_Farmer') ):

    class Noo_Our_Farmer{

        public function __construct(){
            add_action('init', array($this,'register_post_type'));
        }
        public function register_post_type(){

            // Text for NOO farmer.
            $farmer_labels = array(
                'name'          => esc_html__('Farmer', 'noo') ,
                'singular_name' => esc_html__('Farmer', 'noo') ,
                'menu_name'     => esc_html__('Farmer', 'noo') ,
                'add_new'       => esc_html__('Add New', 'noo') ,
                'add_new_item'  => esc_html__('Add New farmer Item', 'noo') ,
                'edit_item'     => esc_html__('Edit farmer Item', 'noo') ,
                'new_item'      => esc_html__('Add New farmer Item', 'noo') ,
                'view_item'     => esc_html__('View farmer', 'noo') ,
                'search_items'  => esc_html__('Search farmer', 'noo') ,
                'not_found'     => esc_html__('No farmer items found', 'noo') ,
                'not_found_in_trash' => esc_html__('No farmer items found in trash', 'noo') ,
                'parent_item_colon'  => ''
            );

            $admin_icon     = '';
            if ( floatval( get_bloginfo( 'version' ) ) >= 3.8 ) {
                $admin_icon = 'dashicons-businessman';
            }

            $farmer_slug = 'farmer';

            // Options
            $farmer_args = array(
                'labels' => $farmer_labels,
                'public' => false,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 5,
                'menu_icon' => $admin_icon,
                'capability_type' => 'post',
                'hierarchical' => false,
                'supports' => array(
                    'title',
                    'editor',
                    'revisions'
                ) ,
                'has_archive' => true,
                'rewrite' => array(
                    'slug' => $farmer_slug,
                    'with_front' => false
                )
            );

            register_post_type('farmer', $farmer_args);

            // Register a taxonomy for Project Categories.
            $category_labels = array(
                'name' => esc_html__('Farmer Categories', 'noo') ,
                'singular_name' => esc_html__('Farmer Category', 'noo') ,
                'menu_name' => esc_html__('Farmer Categories', 'noo') ,
                'all_items' => esc_html__('All Farmer Categories', 'noo') ,
                'edit_item' => esc_html__('Edit Farmer Category', 'noo') ,
                'view_item' => esc_html__('View Farmer Category', 'noo') ,
                'update_item' => esc_html__('Update Farmer Category', 'noo') ,
                'add_new_item' => esc_html__('Add New Farmer Category', 'noo') ,
                'new_item_name' => esc_html__('New Farmer Category Name', 'noo') ,
                'parent_item' => esc_html__('Parent Farmer Category', 'noo') ,
                'parent_item_colon' => esc_html__('Parent Farmer Category:', 'noo') ,
                'search_items' => esc_html__('Search Farmer Categories', 'noo') ,
                'popular_items' => esc_html__('Popular Farmer Categories', 'noo') ,
                'separate_items_with_commas' => esc_html__('Separate Farmer Categories with commas', 'noo') ,
                'add_or_remove_items' => esc_html__('Add or remove Farmer Categories', 'noo') ,
                'choose_from_most_used' => esc_html__('Choose from the most used Farmer Categories', 'noo') ,
                'not_found' => esc_html__('No Farmer Categories found', 'noo') ,
            );

            $category_args = array(
                'labels' => $category_labels,
                'public' => false,
                'show_ui' => true,
                'show_in_nav_menus' => false,
                'show_tagcloud' => false,
                'show_admin_column' => true,
                'hierarchical' => true,
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'farmer_category',
                    'with_front' => false
                ) ,
            );

            register_taxonomy('farmer_category', array(
                'farmer'
            ) , $category_args);
        }



    }
    new Noo_Our_Farmer();
endif;