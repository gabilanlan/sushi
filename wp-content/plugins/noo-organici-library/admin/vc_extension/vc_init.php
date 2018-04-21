<?php
// Incremental ID Counter for Templates
if ( ! function_exists( 'noo_vc_elements_id_increment' ) ) :
    function noo_vc_elements_id_increment() {
        static $count = 0; $count++;
        return $count;
    }
endif;
// Function for handle element's visibility
if ( ! function_exists( 'noo_visibility_class' ) ) :
    function noo_visibility_class( $visibility = '' ) {
        switch ($visibility) {
            case 'hidden-phone':
                return ' hidden-xs';
            case 'hidden-tablet':
                return ' hidden-sm';
            case 'hidden-pc':
                return ' hidden-md hidden-lg';
            case 'visible-phone':
                return ' visible-xs';
            case 'visible-tablet':
                return ' visible-sm';
            case 'visible-pc':
                return ' visible-md visible-lg';
            default:
                return '';
        }
    }
endif;
if ( class_exists('WPBakeryVisualComposerAbstract') ):
    function nootheme_includevisual(){
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/map/new_params.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/map/map.php';
        // VC Templates
        $vc_templates_dir = NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/vc_templates/';
        vc_set_shortcodes_templates_dir($vc_templates_dir);

        // require file
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-boxes.php';

        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-product-grid.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-product-slider.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-product-masonry.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-attributes.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-product-countdown.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo_represent_product.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-product-list.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-product-simgle.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-product-simple-slider.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-farmer.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-farmer-slider.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-testimonial.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-blog.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/our-story.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-our-story2.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-title.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-info.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-image-slider.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-image-signature.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-map.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-instagram.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-about.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-custom-countdown.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-clients.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-blog-list.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-image.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-product-menu.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-services.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-image-grid.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/short_intro.php';
        require_once NOO_PLUGIN_SERVER_PATH . '/admin/vc_extension/shortcodes/noo-mailchimp.php';
    }
    add_action('init', 'nootheme_includevisual', 20);
endif;