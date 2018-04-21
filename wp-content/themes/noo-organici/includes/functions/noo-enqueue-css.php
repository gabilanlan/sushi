<?php
/**
 * NOO Framework Site Package.
 *
 * Register Style
 * This file register & enqueue style used in NOO Themes.
 *
 * @package    NOO Framework
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */
// =============================================================================

function noo_organici_fonts_url()
{
    // Enqueue Fonts.

    $fonts_url = '';

    $headings_font_family = noo_organici_get_theme_default( 'headings_font_family' );
    $body_font_family = noo_organici_get_theme_default( 'font_family' );
    $nav_font_family = noo_organici_get_theme_default( 'nav_font_family' );
    $logo_font_family = noo_organici_get_theme_default( 'logo_font_family' );
    $special_font_family = 'Droid Serif';

    $subsets   = 'latin,latin-ext';

    $font_families = array();

    $noo_typo_use_custom_headings_font = noo_organici_get_option( 'noo_typo_use_custom_headings_font', false );
    $noo_typo_use_custom_body_font     = noo_organici_get_option( 'noo_typo_use_custom_body_font', false );
    $nav_custom_font                   = noo_organici_get_option( 'noo_header_custom_nav_font', false );
    $use_image_logo                    = noo_organici_get_option( 'noo_header_use_image_logo', false );



    $body_trans     =   _x('on', 'Body font: on or off','noo-organici');

    $special_trans  =   _x('on', 'Special font: on or off','noo-organici');

    $heading_trans  =   _x('on', 'Heading font: on or off','noo-organici');

    $nav_trans      =   _x('on', 'Nav font: on or off','noo-organici');

    $logo_trans     =   _x('on', 'Logo font: on or off','noo-organici');

    if( $noo_typo_use_custom_headings_font != false) {
        $headings_font_family   = noo_organici_get_option( 'noo_typo_headings_font', $headings_font_family );
    }

    if( $noo_typo_use_custom_body_font != false) {
        $body_font_family       = noo_organici_get_option( 'noo_typo_body_font', $body_font_family );
    }

    if( $nav_custom_font != false) {
        $nav_font_family    = noo_organici_get_option( 'noo_header_nav_font', $nav_font_family );
    }

    if( $use_image_logo == false) {
        $logo_font_family   = noo_organici_get_option( 'noo_header_logo_font', $logo_font_family );
    }


    if ( 'off' !== $body_trans ) {
        $font_families[] = $body_font_family . ':' . '100,300,400,500,600,700,900,300italic,400italic,700italic,900italic';

    }

    if ( 'off' !== $special_trans ) {
        $font_families[] = $special_font_family . ':' . '100,300,400,500,600,700,900,300italic,400italic,700italic,900italic';

    }

    if ( 'off' !== $heading_trans ) {

        $font_families[] = $headings_font_family . ':' . '100,300,400,500,600,700,900,300italic,400italic,700italic,900italic';

    }

    if ( 'off' !== $nav_trans && $nav_custom_font != false) {

        $font_families[] = $nav_font_family . ':' . '100,300,400,500,600,700,900,300italic,400italic,700italic,900italic';

    }

    if ( 'off' !== $logo_trans && $use_image_logo == false && !empty($logo_font_family)) {

        $font_families[] = $logo_font_family . ':' . '100,300,400,500,600,700,900,300italic,400italic,700italic,900italic';

    }

    $subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'noo-organici' );

    if ( 'cyrillic' == $subset ) {
        $subsets .= ',cyrillic,cyrillic-ext';
    } elseif ( 'greek' == $subset ) {
        $subsets .= ',greek,greek-ext';
    } elseif ( 'devanagari' == $subset ) {
        $subsets .= ',devanagari';
    } elseif ( 'vietnamese' == $subset ) {
        $subsets .= ',vietnamese';
    }

    if ( $font_families ) {
        $fonts_url = add_query_arg( array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( $subsets ),
        ), 'https://fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );

}

if (!function_exists('noo_organici_enqueue_site_style')) :
    function noo_organici_enqueue_site_style()
    {

        if (!is_admin()) {

            if (is_file(noo_organici_upload_dir() . '/custom.css')) {
                wp_register_style('noo-custom-style', noo_organici_upload_url() . '/custom.css', NULL, NULL, 'all');
            }

            wp_register_style('owl_carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css', NULL, NULL, 'all');
            wp_register_style('owl_theme', get_template_directory_uri() . '/assets/css/owl.theme.css', NULL, NULL, 'all');
            wp_enqueue_style('owl_carousel');
            wp_enqueue_style('owl_theme');

            // Vendors
            // Font Awesome
            wp_register_style('vendor-font-awesome-css', get_template_directory_uri() . '/assets/vendor/fontawesome/css/font-awesome.min.css', array(), NULL, NULL);
            wp_enqueue_style('vendor-font-awesome-css');

            wp_register_style( 'css-scroll', get_template_directory_uri() . '/assets/vendor/scrollbar/css/jquery.scrollbar.css', array(), null );


            wp_enqueue_style('noo-organici-fonts', noo_organici_fonts_url(), array(), null);


            wp_enqueue_style('noo-css', get_template_directory_uri() . '/assets/css/noo.css', array(), NULL, NULL);

            wp_register_style( 'prettyPhoto', get_template_directory_uri() . '/assets/vendor/prettyPhoto/css/prettyPhoto.css',array(), null, null );

            if (!noo_organici_get_option('noo_use_inline_css', false) && wp_style_is('noo-custom-style', 'registered')) {
                global $wp_customize;
                if (!isset($wp_customize)) {
                    wp_enqueue_style('noo-custom-style');
                }
            }
            // Main style
            wp_enqueue_style('noo-style', get_stylesheet_directory_uri() . '/style.css', NULL, NULL, 'all');

        }
    }

    add_action('wp_enqueue_scripts', 'noo_organici_enqueue_site_style');
endif;
