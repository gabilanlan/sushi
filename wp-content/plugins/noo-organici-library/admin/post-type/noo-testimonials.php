<?php
/**
 * Register NOO testimonial.
 * This file register Item and Category for NOO testimonial.
 *
 * @package    NOO Framework
 * @subpackage NOO testimonial
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */

if ( ! function_exists('noo_init_testimonial')) :
    function noo_init_testimonial() {

        // Text for NOO testimonial.
        $testimonial_labels = array(
            'name' => esc_html__('Testimonial', 'noo') ,
            'singular_name' => esc_html__('Testimonial', 'noo') ,
            'menu_name' => esc_html__('Testimonial', 'noo') ,
            'add_new' => esc_html__('Add New', 'noo') ,
            'add_new_item' => esc_html__('Add New testimonial Item', 'noo') ,
            'edit_item' => esc_html__('Edit testimonial Item', 'noo') ,
            'new_item' => esc_html__('Add New testimonial Item', 'noo') ,
            'view_item' => esc_html__('View testimonial', 'noo') ,
            'search_items' => esc_html__('Search testimonial', 'noo') ,
            'not_found' => esc_html__('No testimonial items found', 'noo') ,
            'not_found_in_trash' => esc_html__('No testimonial items found in trash', 'noo') ,
            'parent_item_colon' => ''
        );

        $admin_icon = '';
        if ( floatval( get_bloginfo( 'version' ) ) >= 3.8 ) {
            $admin_icon = 'dashicons-testimonial';
        }

        $testimonial_page = get_theme_mod('noo_testimonial_page', '');
        $testimonial_slug = !empty($testimonial_page) ? get_post( $testimonial_page )->post_name : 'noo-testimonial';

        // Options
        $testimonial_args = array(
            'labels' => $testimonial_labels,
            'public' => false,
            // 'publicly_queryable' => true,
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
                'slug' => $testimonial_slug,
                'with_front' => false
            )
        );

        register_post_type('testimonial', $testimonial_args);

        // Register a taxonomy for Project Categories.
        $category_labels = array(
            'name'          => esc_html__('Testimonial Categories', 'noo') ,
            'singular_name' => esc_html__('Testimonial Category', 'noo') ,
            'menu_name'     => esc_html__('Testimonial Categories', 'noo') ,
            'all_items'     => esc_html__('All Testimonial Categories', 'noo') ,
            'edit_item'     => esc_html__('Edit Testimonial Category', 'noo') ,
            'view_item'     => esc_html__('View Testimonial Category', 'noo') ,
            'update_item'   => esc_html__('Update Testimonial Category', 'noo') ,
            'add_new_item'  => esc_html__('Add New Testimonial Category', 'noo') ,
            'new_item_name' => esc_html__('New Testimonial Category Name', 'noo') ,
            'parent_item'   => esc_html__('Parent Testimonial Category', 'noo') ,
            'parent_item_colon' => esc_html__('Parent Testimonial Category:', 'noo') ,
            'search_items' => esc_html__('Search Testimonial Categories', 'noo') ,
            'popular_items' => esc_html__('Popular Testimonial Categories', 'noo') ,
            'separate_items_with_commas' => esc_html__('Separate Testimonial Categories with commas', 'noo') ,
            'add_or_remove_items' => esc_html__('Add or remove Testimonial Categories', 'noo') ,
            'choose_from_most_used' => esc_html__('Choose from the most used Testimonial Categories', 'noo') ,
            'not_found' => esc_html__('No Testimonial Categories found', 'noo') ,
        );

        $category_args = array(
            'labels' => $category_labels,
            'public' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'testimonial_category',
                'with_front' => false
            ) ,
        );

        register_taxonomy('testimonial_category', array(
            'testimonial'
        ) , $category_args);

    }
endif;

add_action('init', 'noo_init_testimonial');