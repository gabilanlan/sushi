<?php
/**
 * NOO Visual Composer Add-ons
 *
 * Customize Visual Composer to suite NOO Framework
 *
 * @package    NOO Framework
 * @subpackage NOO Visual Composer Add-ons
 * @version    1.0.0
 * @author     Kan Nguyen <khanhnq@nootheme.com>
 * @copyright  Copyright (c) 2014, NooTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://nootheme.com
 */
//
// Variables.
//
$category_name        = esc_html__( 'Organici', 'noo' );
$holder               = '';

// custom [row]
vc_add_param('vc_row', array(
        "type"        =>  "checkbox",
        "admin_label" =>  true,
        "heading"     =>  "Using Container",
        "param_name"  =>  "container_width",
        "description" =>  esc_html__( 'If checked container will be set to width 1170px for content.','noo'),
        'weight'      => 1,
        'value'       => array( esc_html__( 'Yes', 'noo' ) => 'yes' )
    )
);
vc_remove_param( "vc_row", "full_width" );



//Register "container" content element. It will hold all your inner (child) content elements
vc_map( array(
    "name"                      => esc_html__("Image Atributes", "noo"),
    "base"                      => "noo_atributes",
    "as_parent"                 => array('only' => 'noo_atributes_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element"           => true,
    "show_settings_on_create"   => false,
    "is_container"              => true,
    "category"                  =>  $category_name,
    'icon'                      => 'icon-wpb-single-image',
    "params"                    => array(
        // add params same as with any other content element
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Image", "noo"),
            "param_name" => "image"
        )
    ),
    "js_view" => 'VcColumnView'
) );
vc_map( array(
    "name"            => esc_html__("Atributes item", "noo"),
    "base"            => "noo_atributes_item",
    "content_element" => true,
    "as_child"        => array('only' => 'noo_atributes'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params"          => array(
        // add params same as with any other content element
        array(
            "type"       => "textfield",
            "heading"    => esc_html__("Title", "noo"),
            "param_name" => "title"
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__("Add link for title", "noo"),
            "param_name" => "link",
            "value"      => '#'
        ),
        array(
            "type"       => "textarea",
            "heading"    => esc_html__("Description", "noo"),
            "param_name" => "description"
        ),
        array(
            "type"       => "attach_image",
            "heading"    => esc_html__("Icon", "noo"),
            "param_name" => "icon"
        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Choose color by class", "noo"),
            "param_name" => "color",
            'value'      => array(
                esc_html__('Green','noo')    =>  'green',
                esc_html__('Orange','noo')   =>  'orange',
                esc_html__('Blue','noo')     =>  'blue',
                esc_html__('Pink','noo')     =>  'pink',
                esc_html__('Grey','noo')     =>  'grey',
                esc_html__('Turquoise','noo')     =>  'turquoise',
            )

        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__("Choose position", "noo"),
            "param_name" => "position",
            'value'      => array(
                esc_html__('Top left','noo')       =>  '1',
                esc_html__('Top center','noo')     =>  '2',
                esc_html__('Top right','noo')      =>  '3',
                esc_html__('Bottom right','noo')   =>  '4',
                esc_html__('Bottom left','noo')    =>  '',
                esc_html__('Bottom center','noo')    =>  '5',
            )

        )
    )
) );
//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Noo_Atributes extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Noo_Atributes_Item extends WPBakeryShortCode {
    }
}





// noo_shortintro
vc_map(array(
    'base'        => 'noo_shortintro',
    'name'        => __( 'Noo Short Introduct', 'noo' ),
    'class'       => 'noo_icon_information',
    'icon'        => 'noo_icon_information',
    'category'    => $category_name,
    'description' => '',
    'params'      => array(
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Price','noo'),
            'param_name'    =>  'price',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Attach','noo'),
            'param_name'    =>  'attach',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Title','noo'),
            'param_name'    =>  'title',
            'value'         =>  ''
        ),

    )
));
// Noo farmer
vc_map(array(
    'base'        => 'noo_farmer',
    'name'        => __( 'Noo Farmer', 'noo' ),
    'class'       => 'noo-icon-farmer',
    'icon'        => 'noo_icon_team_member',
    'category'    => $category_name,
    'description' => '',
    'params'      => array(
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Title','noo'),
            'param_name'    =>  'title',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Description','noo'),
            'param_name'    =>  'description',
            'value'         =>  ''
        ),
        array(
            'param_name'  => 'style',
            'heading'     => esc_html__( 'Choose style', 'noo' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => $holder,
            'value'       => array(
                esc_html__( 'Grid', 'noo' )   => 'grid',
                esc_html__( 'Slider', 'noo' ) => 'slider'
            )
        ),        
        array(
            'type'          =>  'noo_farmer_cat',
            'heading'       =>  esc_html__('Choose Categories','noo'),
            'description'   =>  esc_html__('Display Farmer in categories','noo'),
            'holder'        =>  $holder,
            'param_name'    =>  'cat'
        ),
        array(
            'param_name'  => 'orderby',
            'heading'     => esc_html__( 'Order By', 'noo' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => $holder,
            'value'       => array(
                esc_html__( 'Recent First', 'noo' )             => 'latest',
                esc_html__( 'Older First', 'noo' )              => 'oldest',
                esc_html__( 'Title Alphabet', 'noo' )           => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo' )  => 'ralphabet' )
        ),
        array(
            'param_name'  => 'columns',
            'heading'     => esc_html__( 'Product Columns', 'noo' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => $holder,
            'value'       => array(
                esc_html__( '3 Columns', 'noo' )     => '3',
                esc_html__( '4 Columns', 'noo' )     => '4',
                esc_html__( '2 Columns', 'noo' )     => '2'
            )
        ),
        array(
            'param_name'    =>  'posts_per_page',
            'heading'       =>  esc_html__('Posts per page', 'noo'),
            'description'   =>  esc_html__('The "per_page" shortcode determines how many products to show on the page', 'noo'),
            'type'          =>  'textfield',
            'holder'        =>  $holder
        )
    )
));

// Noo farmer
vc_map(array(
    'base'        => 'noo_farmer_slider',
    'name'        => __( 'Noo Farmer Slider', 'noo' ),
    'class'       => 'noo-icon-farmer',
    'icon'        => 'noo_icon_team_member',
    'category'    => $category_name,
    'description' => '',
    'params'      => array(
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Title','noo'),
            'param_name'    =>  'title',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textarea_html',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Description','noo'),
            'param_name'    =>  'description',

        ),
        array(
            'type'          =>  'noo_farmer_cat',
            'heading'       =>  esc_html__('Choose Categories','noo'),
            'description'   =>  esc_html__('Display Farmer in categories','noo'),
            'holder'        =>  $holder,
            'param_name'    =>  'cat'
        ),
        array(
            'param_name'  => 'orderby',
            'heading'     => esc_html__( 'Order By', 'noo' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => $holder,
            'value'       => array(
                esc_html__( 'Recent First', 'noo' )             => 'latest',
                esc_html__( 'Older First', 'noo' )              => 'oldest',
                esc_html__( 'Title Alphabet', 'noo' )           => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo' )  => 'ralphabet' )
        ),
        array(
            'param_name'    =>  'posts_per_page',
            'heading'       =>  esc_html__('Posts per page', 'noo'),
            'description'   =>  esc_html__('The "per_page" shortcode determines how many products to show on the page', 'noo'),
            'type'          =>  'textfield',
            'holder'        =>  $holder
        ),
        array(
            'param_name'  => 'background_thumb',
            'heading'     => esc_html__( 'Background Your Image', 'noo' ),
            'description' => '',
            'type'        => 'attach_image',
            'holder'      => $holder,
            'value'       =>  ''
        ),
    )
));

// noo_represent_product
vc_map(array(
    'base'        => 'noo_represent_product',
    'name'        => __( 'Noo Represent Product', 'noo' ),
    'class'       => 'noo-icon-represent',
    'icon'        => 'noo_icon_noo_grid',
    'category'    => $category_name,
    'description' => '',
    'params'      => array(
        array(
            'type'          =>  'attach_image',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Icon','noo'),
            'param_name'    =>  'icon',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Title','noo'),
            'param_name'    =>  'title',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textarea',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Description','noo'),
            'param_name'    =>  'description',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Button name','noo'),
            'param_name'    =>  'button_name',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Button link','noo'),
            'param_name'    =>  'button_link',
            'value'         =>  '#'
        )
    )
));

//[noo_testimonial]
$cat = array();
$cat['All'] = 'all';
if(class_exists('Noo_Organici_Library')):
    $categories = get_categories( array( 'taxonomy'  => 'testimonial_category' ) );
    if ( isset( $categories ) && !empty( $categories ) ):
        foreach( $categories as $cate ):
            $cat[ $cate->name ] = $cate -> term_id;
        endforeach;
    endif;
endif;
vc_map(array(
    'name'      =>  esc_html__('Noo Testimonial','noo'),
    'base'      =>  'noo_testimonial',
    'description'   =>  esc_html__('Display post type testimonial','noo'),
    'icon'      =>  'noo_icon_testimonial',
    'category'  =>   $category_name,
    'params'    =>  array(
        array(
            'param_name'  => 'style',
            'heading'     => esc_html__( 'Choose Style', 'noo' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => $holder,
            'value'       => array(
                esc_html__( 'Style Pagination', 'noo' )        => 'one',
                esc_html__( 'Style Thumbnail top', 'noo' )     => 'two',
                esc_html__( 'Style Thumbnail bottom', 'noo' )  => 'three'
            )
        ),
        array(
            'param_name'  => 'categories',
            'heading'     => esc_html__( 'Categories', 'noo' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => $holder,
            'value'       =>  $cat
        ),
        array(
            'param_name'  => 'background_thumb',
            'heading'     => esc_html__( 'Background Your Thumbnail', 'noo' ),
            'description' => '',
            'type'        => 'attach_image',
            'holder'      => $holder,
            'value'       =>  ''
        ),
        array(
            'param_name'  => 'posts_per_page',
            'heading'     => esc_html__( 'Limited Testimonial', 'noo' ),
            'description' => '',
            'type'        => 'textfield',
            'holder'      => $holder,
            'value'       => 10
        ),
        array(
            'param_name'  => 'orderby',
            'heading'     => esc_html__( 'Order By', 'noo' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => $holder,
            'value'       => array(
                esc_html__( 'Recent First', 'noo' ) => 'latest',
                esc_html__( 'Older First', 'noo' ) => 'oldest',
                esc_html__( 'Title Alphabet', 'noo' ) => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo' ) => 'ralphabet' )
        ),
        array(
            'param_name'  => 'autoplay',
            'heading'     => esc_html__( 'Auto Play', 'noo' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => $holder,
            'value'       =>  array(
                esc_html__( 'Yes', 'noo' )   =>  'true',
                esc_html__( 'No', 'noo' )    =>  'false'
            )
        ),
        array(
            'param_name'  => 'line',
            'heading'     => esc_html__( 'Show line ?', 'noo' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => $holder,
            'value'       =>  array(
                esc_html__( 'No', 'noo' )    =>  'hide',
                esc_html__( 'Yes', 'noo' )   =>  'show'
            )
        ),
        array(
            'param_name'  => 'image_left',
            'heading'     => esc_html__( 'Image Left', 'noo' ),
            'description' => '',
            'type'        => 'attach_image',
            'holder'      => $holder,
            'value'       =>  '',
            'dependency'    => array(
                'element'   => 'style',
                'value'     => array( 'three' )
            ),
        ),
        array(
            'param_name'  => 'image_right',
            'heading'     => esc_html__( 'Image Right', 'noo' ),
            'description' => '',
            'type'        => 'attach_image',
            'holder'      => $holder,
            'value'       =>  '',
            'dependency'    => array(
                'element'   => 'style',
                'value'     => array( 'three' )
            ),
        ),
    )
));





//[noo_blog]
add_filter( 'vc_autocomplete_noo_blog_include_callback',
    'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_noo_blog_include_render',
    'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
vc_map(array(
    'name'          =>  esc_html__('Noo Blog Masonry','noo'),
    'base'          =>  'noo_blog',
    'description'   =>  esc_html__('Display posts','noo'),
    'icon'          =>  'noo_icon_blog',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'param_name'    => 'style_title',
            'heading'       => esc_html__( 'Style title', 'noo' ),
            'type'          => 'dropdown',
            'admin_label'   => true,
            'holder'        => $holder,
            'value'         => array(
                esc_html__('One','noo')   => 'one',
                esc_html__('Two','noo')   =>  'two'
            ),
        ),
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Icon', 'noo' ),
            'param_name'    => 'icon',
            'admin_label'   => true,
            'holder'        => $holder,
            'dependency'    => array(
                'element'   => 'style_title',
                'value'     => array( 'two' )
            ),
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Attach', 'noo' ),
            'param_name'    => 'attach',
            'admin_label'   => true,
            'holder'        => $holder,
            'dependency'    => array(
                'element'   => 'style_title',
                'value'     => array( 'two' )
            ),
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Title','noo'),
            'param_name'    =>  'title',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textarea',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Description','noo'),
            'param_name'    =>  'description',
            'value'         =>  ''
        ),
        array(
            'param_name'    =>  'type_query',
            'heading'       =>  esc_html__('Data Source', 'noo'),
            'description'   =>  esc_html__('Select content type', 'noo'),
            'type'          =>  'dropdown',
            'admin_label'   => true,
            'holder'        =>  $holder,
            'value'         =>  array(
                'Category'      =>  'cate',
                'Tags'          =>  'tag',
                'Posts'         =>  'post_id'
            )
        ),
        array(
            'param_name'    => 'categories',
            'heading'       => esc_html__( 'Categories', 'noo' ),
            'description'   => esc_html__('Select categories.', 'noo' ),
            'type'          => 'post_categories',
            'admin_label'   => true,
            'holder'        => $holder,
            'dependency'    => array(
                'element'   => 'type_query',
                'value'     => array( 'cate' )
            ),
        ),
        array(
            'param_name'    => 'tags',
            'heading'       => esc_html__( 'Tags', 'noo' ),
            'description'   => esc_html__('Select Tags.', 'noo' ),
            'type'          => 'post_tags',
            'admin_label'   => true,
            'holder'        => $holder,
            'dependency'    => array(
                'element'   => 'type_query',
                'value'     => array( 'tag' )
            ),
        ),
        array(
            'type'        => 'autocomplete',
            'heading'     => esc_html__( 'Include only', 'noo' ),
            'param_name'  => 'include',
            'description' => esc_html__( 'Add posts, pages, etc. by title.', 'noo' ),
            'admin_label'   => true,
            'holder'        => $holder,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups'   => true,
            ),
            'dependency'    => array(
                'element'   => 'type_query',
                'value'     => array( 'post_id' )
            ),
        ),
        array(
            'param_name'  => 'orderby',
            'heading'     => esc_html__( 'Order By', 'noo' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => $holder,
            'value'       => array(
                esc_html__( 'Recent First', 'noo' ) => 'latest',
                esc_html__( 'Older First', 'noo' ) => 'oldest',
                esc_html__( 'Title Alphabet', 'noo' ) => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo' ) => 'ralphabet' )
        ),
        array(
            'type'          =>  'dropdown',
            'heading'       =>  esc_html__('Choose columns','noo'),
            'holder'        =>  $holder,
            'param_name'    =>  'columns',
            'value'         =>  array(
                '2'         =>  esc_html__('2 columns','noo'),
                '3'         =>  esc_html__('3 columns','noo'),
                '4'         =>  esc_html__('4 columns','noo')
            )
        ),
        array(
            'param_name'  => 'posts_per_page',
            'heading'     => esc_html__( 'Posts Per Page', 'noo' ),
            'description' => '',
            'type'        => 'textfield',
            'holder'      => $holder,
            'value'       => 10
        ),
        array(
            'param_name'   => 'limit_excerpt',
            'heading'      => esc_html__( 'Excerpt Length', 'noo' ),
            'description'  => '',
            'type'         => 'textfield',
            'holder'       => $holder,
            'value'        =>  15
        ),
        array(
            'param_name'  =>  'show_loadmore',
            'type'        =>  'checkbox',
            'heading'     =>  'Show Loadmore Button',
            'description' =>  esc_html__( 'If checked Button Loadmore will be show under content.','noo'),
            'weight'      => 1,
            'value'       => array( esc_html__( 'Yes', 'noo' ) => 'yes' )
        )
    )
));

//[noo_our_story]
vc_map(array(
    'name'          =>  esc_html__('Noo Our Story','noo'),
    'base'          =>  'noo_our_story',
    'description'   =>  esc_html__('Display content','noo'),
    'icon'          =>  'noo_icon_blog',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Title','noo'),
            'param_name'    =>  'title',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textarea_html',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Content','noo'),
            'param_name'    =>  'content',

        ),
        array(
            'type'          =>  'attach_image',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Signature','noo'),
            'description'   =>  esc_html__('Display Signature by type image','noo'),
            'param_name'    =>  'signature',
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Button Name','noo'),
            'param_name'    =>  'button_name',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Button Link','noo'),
            'param_name'    =>  'button_link',
            'value'         =>  '#'
        ),
        array(
            'type'          =>  'attach_images',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Galley','noo'),
            'description'   =>  esc_html__('Display images','noo'),
            'param_name'    =>  'galley',
        )
    )
));

//[noo_our_story2]
vc_map(array(
    'name'          =>  esc_html__('Noo Our Story 2','noo'),
    'base'          =>  'noo_our_story2',
    'description'   =>  esc_html__('Display content','noo'),
    'icon'          =>  'noo_icon_blog',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Title','noo'),
            'param_name'    =>  'title',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textarea_html',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Content','noo'),
            'param_name'    =>  'content',

        ),
        array(
            'type'          =>  'attach_image',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Background','noo'),
            'param_name'    =>  'background',
        ),
        array(
            'type'          =>  'attach_image',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Signature','noo'),
            'description'   =>  esc_html__('Display Signature by type image','noo'),
            'param_name'    =>  'signature',
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Name','noo'),
            'param_name'    =>  'name',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Position','noo'),
            'param_name'    =>  'position',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'attach_image',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Image Bottom','noo'),
            'param_name'    =>  'image_bottom',
        )
    )
));

//[noo_image_signature]
vc_map(array(
    'name'          =>  esc_html__('Noo Image Signature','noo'),
    'base'          =>  'noo_image_signature',
    'description'   =>  esc_html__('Display Image With Signature','noo'),
    'icon'          =>  'noo_icon_blog',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          =>  'attach_image',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Image','noo'),
            'param_name'    =>  'image',
        ),
        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__( 'Background Color', 'noo' ),
            'description' => '',
            'holder'      => $holder,
            'value'       =>  '',
            'param_name'  => 'background_color',
        ),
        array(
            'type'          =>  'attach_image',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Signature','noo'),
            'description'   =>  esc_html__('Display Signature by type image','noo'),
            'param_name'    =>  'signature',
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Name','noo'),
            'param_name'    =>  'name',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Position','noo'),
            'param_name'    =>  'position',
            'value'         =>  ''
        )
    )
));

//[noo_title]
vc_map(array(
    'name'          =>  esc_html__('Noo Title','noo'),
    'base'          =>  'noo_title',
    'description'   =>  esc_html__('Display Title','noo'),
    'icon'          =>  'noo_icon_title',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Title','noo'),
            'param_name'    =>  'title',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textarea',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Description','noo'),
            'param_name'    =>  'description',
            'value'         =>  ''
        )
    )
));

//[noo_info]
vc_map(array(
    'name'          =>  esc_html__('Noo Info','noo'),
    'base'          =>  'noo_info',
    'description'   =>  esc_html__('Display Info','noo'),
    'icon'          =>  'noo_icon_title',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          =>  'attach_image',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Icon','noo'),
            'param_name'    =>  'icon',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Number','noo'),
            'param_name'    =>  'number',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Title','noo'),
            'param_name'    =>  'title',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textarea',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Description','noo'),
            'param_name'    =>  'desc',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'dropdown',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Color','noo'),
            'param_name'    =>  'color',
            'value'         =>  array(
                esc_html__('Green','noo')         =>  'green',
                esc_html__('Orange','noo')        =>  'noo-orange',
                esc_html__('Sandy brown','noo')   =>  'noo-sandy-brown',
                esc_html__('Turquoise','noo')     =>  'noo-turquoise'
            )
        ),
        array(
            'type'          =>  'dropdown',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Position','noo'),
            'param_name'    =>  'position',
            'value'         =>  array(
                esc_html__('Left','noo')    =>  '',
                esc_html__('Right','noo')   =>  ' noo-info-right'
            )
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'noo' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'noo' ),
        )
    )
));
class WPBakeryShortCode_Noo_Info extends WPBakeryShortCode {
}



//[noo_image_slider]
vc_map(array(
    'name'          =>  esc_html__('Noo Images Slider','noo'),
    'base'          =>  'noo_image_slider',
    'description'   =>  esc_html__('Display images slider','noo'),
    'icon'          =>  'noo_icon_slider',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          =>  'dropdown',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Config columns slider','noo'),
            'param_name'    =>  'columns',
            'value'         =>  array(
                esc_html__('3 columns','noo')     =>  '3',
                esc_html__('5 columns','noo')     =>  '5',
                esc_html__('4 columns','noo')     =>  '4',
                esc_html__('2 columns','noo')     =>  '2',
                esc_html__('1 columns','noo')     =>  '1'
            )
        ),
        array(
            'type'          =>  'dropdown',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Auto Slider','noo'),
            'param_name'    =>  'auto_slider',
            'value'         =>  array(
                esc_html__('False','noo')     =>  'false',
                esc_html__('True','noo')     =>  'true'
            )
        ),
        array(
            'type'          =>  'dropdown',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Using padding ?','noo'),
            'param_name'    =>  'padding',
            'value'         =>  array(
                esc_html__('Yes','noo')     =>  '',
                esc_html__('No','noo')     =>   ' no-padding'
            )
        ),
        array(
            'type' => 'param_group',
            'value' => '',
            'param_name' => 'slider',
            'params' => array(
                array(
                    'type'       => 'attach_image',
                    'value'      => '',
                    'heading'    => 'Upload image',
                    'param_name' => 'image',
                ),
                array(
                    'type'       => 'textfield',
                    'value'      => '',
                    'heading'    => 'Link image',
                    'param_name' => 'link',
                ),
            )
        )
    )
));

//[noo_image_grid]
vc_map(array(
    'name'          =>  esc_html__('Noo Images Grid','noo'),
    'base'          =>  'noo_image_grid',
    'description'   =>  esc_html__('Display images grid','noo'),
    'icon'          =>  'noo_icon_slider',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          =>  'dropdown',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Config columns','noo'),
            'param_name'    =>  'columns',
            'value'         =>  array(
                esc_html__('3 columns','noo')     =>  '3',
                esc_html__('5 columns','noo')     =>  '5',
                esc_html__('4 columns','noo')     =>  '4',
                esc_html__('2 columns','noo')     =>  '2',
                esc_html__('1 columns','noo')     =>  '1'
            )
        ),
        array(
            'type' => 'param_group',
            'value' => '',
            'param_name' => 'images',
            'params' => array(
                array(
                    'type'       => 'attach_image',
                    'value'      => '',
                    'heading'    => 'Upload image',
                    'param_name' => 'image',
                ),
                array(
                    'type'       => 'textfield',
                    'value'      => '',
                    'heading'    => 'Link image',
                    'param_name' => 'link',
                ),
            )
        )
    )
));


//[noo_instagram]
vc_map(array(
    'name'          =>  esc_html__('Noo Instagram','noo'),
    'base'          =>  'noo_instagram',
    'description'   =>  esc_html__('Display image on Instagram','noo'),
    'icon'          =>  'noo_icon_information',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Icon', 'noo' ),
            'param_name'    => 'icon',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Attach', 'noo' ),
            'param_name'    => 'attach',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo' ),
            'param_name'    => 'title',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textarea',
            'heading'       => esc_html__( 'Description', 'noo' ),
            'param_name'    => 'description',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          =>  'textfield',
            'heading'       =>  esc_html__('Instagram Username','noo'),
            'holder'        =>  $holder,
            'param_name'    =>  'instagram_username'
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Number of Images','noo'),
            'param_name'    =>  'number',
            'value'         =>  10
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Check for new images on every (hours)','noo'),
            'param_name'    =>  'refresh_hour',
            'value'         =>  4
        ),
        array(
            'param_name'    => 'randomise',
            'heading'       => __( 'Randomise Images: ', 'noo' ),
            'type'          => 'checkbox',
            'value'         => array( '' => 'true' ),
            'holder'        => $holder
        ),
    )
));

//[noo_about]
vc_map(array(
    'name'          =>  esc_html__('Noo About us','noo'),
    'base'          =>  'noo_about',
    'description'   =>  esc_html__('Display content','noo'),
    'icon'          =>  'noo_icon_information',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          =>  'attach_image',
            'heading'       =>  esc_html__('Image left','noo'),
            'holder'        =>  $holder,
            'param_name'    =>  'background_left'
        ),
        array(
            'type'          =>  'attach_image',
            'heading'       =>  esc_html__('Icon','noo'),
            'holder'        =>  $holder,
            'param_name'    =>  'icon'
        ),
        array(
            'type'          => 'textarea',
            'heading'       => esc_html__( 'Description', 'noo' ),
            'param_name'    => 'description',
            'admin_label'   => true,
            'holder'        => $holder
        ),
         array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Button Name', 'noo' ),
            'param_name'    => 'button_name',
            'admin_label'   => true,
            'holder'        => $holder
        ),
         array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Button Link', 'noo' ),
            'param_name'    => 'button_link',
            'admin_label'   => true,
            'holder'        => $holder
        )

    )
));

// [noo_custom_countdown]
vc_map(array(
    'base'        => 'noo_custom_countdown',
    'name'        => __( 'Custom Countdown', 'noo' ),
    'class'       => 'noo-icon-countdown',
    'icon'        => 'noo-icon-countdown',
    'category'    => $category_name,
    'description' => '',
    'params'      => array(
        array(
            'param_name'    => 'link',
            'heading'       => __( 'Custom link', 'noo' ),
            'description'   => '',
            'type'          => 'textfield',
            'admin_label'   => true,
            'holder'        => $holder,
            'value'         =>  '#'
        ),
        array(
            'param_name'    => 'date',
            'heading'       => __( 'Choose date', 'noo' ),
            'description'   => '',
            'type'          => 'noo_datepicker',
            'format'        => 'mm/dd/yy',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Icon', 'noo' ),
            'param_name'    => 'icon',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Attach', 'noo' ),
            'param_name'    => 'attach',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo' ),
            'param_name'    => 'title',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textarea',
            'heading'       => esc_html__( 'Description', 'noo' ),
            'param_name'    => 'description',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Price', 'noo' ),
            'param_name'    => 'price',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Image', 'noo' ),
            'param_name'    => 'image',
            'admin_label'   => true,
            'holder'        => $holder
        )
    )
));



//[noo_clients]
vc_map(array(
    'name'          =>  esc_html__('Noo Clients','noo'),
    'base'          =>  'noo_clients',
    'description'   =>  esc_html__('Display Clients','noo'),
    'icon'          =>  'noo_icon_team_member',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Icon', 'noo' ),
            'param_name'    => 'icon',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Attach', 'noo' ),
            'param_name'    => 'attach',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo' ),
            'param_name'    => 'title',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textarea',
            'heading'       => esc_html__( 'Description', 'noo' ),
            'param_name'    => 'description',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          =>  'dropdown',
            'holder'        =>  $holder,
            'class'         =>  '',
            'heading'       =>  esc_html__('Config columns','noo'),
            'param_name'    =>  'columns',
            'value'         =>  array(
                esc_html__('3 columns','noo')     =>  '3',
                esc_html__('2 columns','noo')     =>  '2',
                esc_html__('4 columns','noo')     =>  '4'

            )
        ),
        array(
            'type' => 'param_group',
            'value' => '',
            'param_name' => 'clients',
            'params' => array(
                array(
                    'type'       => 'attach_image',
                    'value'      => '',
                    'heading'    => 'Upload image',
                    'param_name' => 'image',
                ),
                array(
                    'type'       => 'textfield',
                    'value'      => '',
                    'heading'    => 'Link image',
                    'param_name' => 'link',
                ),
            )
        )
    )
));



//[noo_blog_list]
add_filter( 'vc_autocomplete_noo_blog_list_include_callback',
    'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_noo_blog_list_include_render',
    'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

vc_map(array(
    'name'          =>  esc_html__('Noo Blog List','noo'),
    'base'          =>  'noo_blog_list',
    'description'   =>  esc_html__('Display Blog by style list','noo'),
    'icon'          =>  'noo_list_icon',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Icon', 'noo' ),
            'param_name'    => 'icon',
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Attach', 'noo' ),
            'param_name'    => 'attach',
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo' ),
            'param_name'    => 'title',
            'holder'        => $holder
        ),
        array(
            'type'          => 'textarea',
            'heading'       => esc_html__( 'Description', 'noo' ),
            'param_name'    => 'description',
            'holder'        => $holder
        ),
        array(
            'param_name'    =>  'type_query',
            'heading'       =>  esc_html__('Data Source', 'noo'),
            'description'   =>  esc_html__('Select content type', 'noo'),
            'type'          =>  'dropdown',
            'holder'        =>  $holder,
            'value'         =>  array(
                'Category'      =>  'cate',
                'Tags'          =>  'tag',
                'Posts'         =>  'post_id'
            )
        ),
        array(
            'param_name'    => 'categories',
            'heading'       => esc_html__( 'Categories', 'noo' ),
            'description'   => esc_html__('Select categories.', 'noo' ),
            'type'          => 'post_categories',
            'holder'        => $holder,
            'dependency'    => array(
                'element'   => 'type_query',
                'value'     => array( 'cate' )
            ),
        ),
        array(
            'param_name'    => 'tags',
            'heading'       => esc_html__( 'Tags', 'noo' ),
            'description'   => esc_html__('Select Tags.', 'noo' ),
            'type'          => 'post_tags',
            'holder'        => $holder,
            'dependency'    => array(
                'element'   => 'type_query',
                'value'     => array( 'tag' )
            ),
        ),
        array(
            'type'        => 'autocomplete',
            'heading'     => esc_html__( 'Include only', 'noo' ),
            'param_name'  => 'include',
            'description' => esc_html__( 'Add posts, pages, etc. by title.', 'noo' ),
            'holder'        => $holder,
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups'   => true,
            ),
            'dependency'    => array(
                'element'   => 'type_query',
                'value'     => array( 'post_id' )
            ),
        ),
        array(
            'param_name'  => 'orderby',
            'heading'     => esc_html__( 'Order By', 'noo' ),
            'description' => '',
            'type'        => 'dropdown',
            'holder'      => $holder,
            'value'       => array(
                esc_html__( 'Recent First', 'noo' ) => 'latest',
                esc_html__( 'Older First', 'noo' ) => 'oldest',
                esc_html__( 'Title Alphabet', 'noo' ) => 'alphabet',
                esc_html__( 'Title Reversed Alphabet', 'noo' ) => 'ralphabet' )
        ),
        array(
            'param_name'  => 'posts_per_page',
            'heading'     => esc_html__( 'Posts Per Page', 'noo' ),
            'description' => '',
            'type'        => 'textfield',
            'holder'      => $holder,
            'value'       => 3
        ),
    )
));

//[noo_image]
vc_map(array(
    'name'          =>  esc_html__('Noo Image','noo'),
    'base'          =>  'noo_image',
    'description'   =>  esc_html__('Display image','noo'),
    'icon'          =>  'icon-wpb-single-image',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Upload image', 'noo' ),
            'param_name'    => 'image',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Link image', 'noo' ),
            'param_name'    => 'link',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'image height', 'noo' ),
            'param_name'    => 'height',
            'admin_label'   => true,
            'holder'        => $holder,
            'value'         =>  '840'
        ),
    )
));


//[noo_services]
vc_map(array(
    'name'          =>  esc_html__('Noo Services','noo'),
    'base'          =>  'noo_services',
    'description'   =>  esc_html__('Display Services','noo'),
    'icon'          =>  'noo_icon_services',
    'category'      =>   $category_name,
    'params'        =>  array(
        array(
            'type'          => 'attach_image',
            'heading'       => esc_html__( 'Icon', 'noo' ),
            'param_name'    => 'icon',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Attach', 'noo' ),
            'param_name'    => 'attach',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textfield',
            'heading'       => esc_html__( 'Title', 'noo' ),
            'param_name'    => 'title',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type'          => 'textarea',
            'heading'       => esc_html__( 'Description', 'noo' ),
            'param_name'    => 'description',
            'admin_label'   => true,
            'holder'        => $holder
        ),
        array(
            'type' => 'param_group',
            'value' => '',
            'param_name' => 'services',
            'params' => array(
                array(
                    'type'       => 'textfield',
                    'value'      => '',
                    'heading'    =>  esc_html__('Title','noo'),
                    'param_name' => 'title'
                ),
                array(
                    'type'       => 'attach_image',
                    'value'      => '',
                    'heading'    => 'Upload image',
                    'param_name' => 'image',
                ),
                array(
                    'type'          =>  'textfield',
                    'holder'        =>  $holder,
                    'heading'       =>  esc_html__('Image Link','noo'),
                    'param_name'    =>  'image_link',
                    'value'         =>  '#'
                ),
                array(
                    'type'          => 'textarea',
                    'heading'       => esc_html__( 'Description', 'noo' ),
                    'param_name'    => 'description',
                    'admin_label'   => true,
                    'holder'        => $holder
                ),
            )
        )
    )
));

//[noo_mailchimp]

vc_map(array(
    'name'      =>  esc_html__('Noo Mailchimp','noo'),
    'base'      =>  'noo_mailchimp',
    'description'   =>  esc_html__('Displays your MailChimp for WordPress sign-up form','noo'),
    'icon'      =>  'noo_icon_mailchimp',
    'category'  =>   $category_name,
    'params'    =>  array(
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'heading'       =>  esc_html__('Title','noo'),
            'param_name'    =>  'title',
            'value'         =>  ''
        ),
        array(
            'type'          =>  'textfield',
            'holder'        =>  $holder,
            'heading'       =>  esc_html__('Description','noo'),
            'param_name'    =>  'desc',
            'value'         =>  ''
        ),

    )
));

// Noo Map
vc_map(
    array(
        'base'          => 'noo_map',
        'name'          => esc_html__( 'Noo Map', 'noo' ),
        'icon'          => 'noo_icon_map',
        'description'   =>  esc_html__('Map block','noo'),
        'category'      => $category_name,
        'params'        => array(
            array(
                'param_name' => 'latitude',
                'description' => esc_html__('Leave blank if you use Multi Location', 'noo'),
                'heading'    => esc_html__( 'Latitude', 'noo' ),
                'type'       => 'textfield',
                'holder'     => $holder
            ),
            array(
                'param_name' => 'longitude',
                'description' => esc_html__('Leave blank if you use Multi Location', 'noo'),
                'heading'    => esc_html__( 'Longitude', 'noo' ),
                'type'       => 'textfield',
                'holder'     => $holder
            ),
            array(
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'mark_item',
                'group'         => esc_html__( 'Multi Location', 'noo' ),
                'params' => array(
                     array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Description', 'noo' ),
                        'param_name'    => 'desc',
                        'admin_label'   => true,
                        'holder'        => $holder
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Latitude', 'noo' ),
                        'param_name'    => 'lat',
                        'admin_label'   => true,
                        'holder'        => $holder
                    ),
                    array(
                        'type'       => 'textfield',
                        'value'      => '',
                        'heading'    =>  esc_html__('Longitude','noo'),
                        'param_name' => 'lon',
                        'admin_label'   => true,
                    ),
                )
            ),
            array(
                'param_name' => 'icon',
                'heading'    => esc_html__( 'Icon Map', 'noo' ),
                'type'       => 'attach_image',
                'holder'     => $holder
            ),
            array(
                'param_name' => 'height',
                'heading'    => esc_html__( 'Height Map', 'noo' ),
                'type'       => 'textfield',
                'holder'     => $holder,
                'value'      => '500'
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__( 'Title', 'noo' ),
                'param_name'    => 'title',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          => 'textarea',
                'heading'       => esc_html__( 'Description', 'noo' ),
                'param_name'    => 'description',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__( 'Location', 'noo' ),
                'param_name'    => 'location',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__( 'Email', 'noo' ),
                'param_name'    => 'email',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__( 'Phone', 'noo' ),
                'param_name'    => 'phone',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__( 'Website', 'noo' ),
                'param_name'    => 'website',
                'admin_label'   => true,
                'holder'        => $holder
            ),
        )
    )
);

if( class_exists('WooCommerce') ){

    //[noo_boxes]
    vc_map(array(
        'name'      =>  esc_html__('Noo Boxes','noo'),
        'base'      =>  'noo_boxes',
        'class'     => '',
        'icon'      => 'noo_icon_noo_boxes',
        'category'  =>   $category_name,
        'params'    =>  array(
            array(
                'type'          =>  'categories_boxes',
                'heading'       =>  esc_html__('Choose boxed','noo'),
                'description'   =>  esc_html__('Display product in boxed','noo'),
                'holder'        =>  $holder,
                'param_name'    =>  'cat'
            ),
            array(
                'type'          =>  'dropdown',
                'heading'       =>  esc_html__('Choose columns','noo'),
                'holder'        =>  $holder,
                'param_name'    =>  'columns',
                'value'         =>  array(
                    esc_html__('3 columns','noo')         =>  '3',
                    esc_html__('4 columns','noo')         =>  '4',
                    esc_html__('2 columns','noo')         =>   '2'
                )
            )
        )
    ));

//[noo_product_grid]
    vc_map(array(
        'name'      =>  esc_html__('Noo Product Grid','noo'),
        'base'      =>  'noo_product_grid',
        'class'     => '',
        'icon'      => 'noo_icon_noo_grid',
        'category'  =>   $category_name,
        'params'    =>  array(
            array(
                'type'          =>  'attach_image',
                'heading'       =>  esc_html__('Icon Image','noo'),
                'holder'        =>  $holder,
                'param_name'    =>  'icon'
            ),
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Title','noo'),
                'param_name'    =>  'title',
                'value'         =>  ''
            ),
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Description','noo'),
                'param_name'    =>  'description',
                'value'         =>  ''
            ),
            array(
                'param_name'  => 'style',
                'heading'     => esc_html__( 'Choose Style', 'noo' ),
                'description' => '',
                'type'        => 'dropdown',
                'holder'      => $holder,
                'value'       => array(
                    esc_html__( 'One', 'noo' )             => 'one',
                    esc_html__( 'Two', 'noo' )              => 'two',
                )
            ),
            array(
                'type'          =>  'noo_product_cat',
                'heading'       =>  esc_html__('Choose Categories','noo'),
                'description'   =>  esc_html__('Display product in categories','noo'),
                'holder'        =>  $holder,
                'param_name'    =>  'cat'
            ),
            array(
                'param_name'  => 'columns',
                'heading'     => esc_html__( 'Product Columns', 'noo' ),
                'description' => '',
                'type'        => 'dropdown',
                'holder'      => $holder,
                'value'       => array(
                    esc_html__( '6 Columns', 'noo' )     => '6',
                    esc_html__( '5 Columns', 'noo' )     => '5',
                    esc_html__( '4 Columns', 'noo' )     => '4',
                    esc_html__( '3 Columns', 'noo' )     => '3',
                    esc_html__( '2 Columns', 'noo' )     => '2'
                )
            ),
            array(
                'param_name'  => 'orderby',
                'heading'     => esc_html__( 'Order By', 'noo' ),
                'description' => '',
                'type'        => 'dropdown',
                'holder'      => $holder,
                'value'       => array(
                    esc_html__( 'Recent First', 'noo' )             => 'latest',
                    esc_html__( 'Older First', 'noo' )              => 'oldest',
                    esc_html__( 'Title Alphabet', 'noo' )           => 'alphabet',
                    esc_html__( 'Title Reversed Alphabet', 'noo' )  => 'ralphabet' )
            ),
            array(
                'type'          =>  'checkbox',
                'heading'       =>  esc_html__('Show All Products filter','noo'),
                'holder'        =>  $holder,
                'param_name'    =>  'showall',
                'std'           => 'true',
                'value'         => 'true'
            ),
            array(
                'type'          =>  'attach_image',
                'heading'       =>  esc_html__('Icon Image for All Products filter','noo'),
                'holder'        =>  $holder,
                'param_name'    =>  'filter_all_icon',
                'dependency'    => array('element' =>  'showall', 'value'   =>  'true')
            ),
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Limit','noo'),
                'param_name'    =>  'posts_per_page',
                'value'         =>  8
            ),
            array(
                'param_name'  => 'withcat',
                'heading'     => esc_html__( 'Limit with', 'noo' ),
                'description' => '',
                'type'        => 'dropdown',
                'holder'      => $holder,
                'value'       => array(
                    esc_html__( 'Total number of products', 'noo' ) => 'all',
                    esc_html__( 'Number of products per category', 'noo' )   => 'cat'
                )
            ),
        )
    ));

//[noo_product_slider]
    vc_map(array(
        'name'      =>  esc_html__('Noo Product Slider','noo'),
        'base'      =>  'noo_product_slider',
        'class'     => '',
        'icon'      => 'noo_icon_noo_grid',
        'category'  =>   $category_name,
        'params'    =>  array(
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Title','noo'),
                'param_name'    =>  'title',
                'value'         =>  ''
            ),
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Description','noo'),
                'param_name'    =>  'description',
                'value'         =>  ''
            ),

            array(
                'param_name'  => 'style',
                'heading'     => esc_html__( 'Choose Style', 'noo' ),
                'description' => '',
                'type'        => 'dropdown',
                'holder'      => $holder,
                'value'       => array(
                    esc_html__( 'One', 'noo' )             => 'one',
                    esc_html__( 'Two', 'noo' )              => 'two',
                )
            ),

            array(
                'type'          =>  'noo_product_cat',
                'heading'       =>  esc_html__('Choose Categories','noo'),
                'description'   =>  esc_html__('Display product in categories','noo'),
                'holder'        =>  $holder,
                'param_name'    =>  'cat'
            ),
            array(
                'type'          =>  'attach_image',
                'heading'       =>  esc_html__('Filter All Icon Image','noo'),
                'holder'        =>  $holder,
                'param_name'    =>  'filter_all_icon'
            ),
            array(
                'param_name'  => 'orderby',
                'heading'     => esc_html__( 'Order By', 'noo' ),
                'description' => '',
                'type'        => 'dropdown',
                'holder'      => $holder,
                'value'       => array(
                    esc_html__( 'Recent First', 'noo' )             => 'latest',
                    esc_html__( 'Older First', 'noo' )              => 'oldest',
                    esc_html__( 'Title Alphabet', 'noo' )           => 'alphabet',
                    esc_html__( 'Title Reversed Alphabet', 'noo' )  => 'ralphabet' )
            ),
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Limit','noo'),
                'param_name'    =>  'posts_per_page',
                'value'         =>  10
            ),
        )
    ));

    vc_map(array(
        "name"          =>  esc_html__("Product Masonry", "noo"),
        'description'   =>  esc_html__('Display products','noo'),
        "base"          =>  "noo_product_masonry",
        "category"      =>  $category_name,
        "icon"          =>  "noo_icon_noo_grid",
        "params"        =>  array(
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Title','noo'),
                'param_name'    =>  'title',
                'value'         =>  ''
            ),
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Description','noo'),
                'param_name'    =>  'description',
                'value'         =>  ''
            ),
            array(
                'param_name'    => 'data',
                'heading'       => esc_html__('Choose Data', 'noo'),
                'description'   => '',
                'type'          => 'dropdown',
                'horder'        => $holder,
                'admin_label'   => true,
                'value'         => array(
                    esc_html__('Recent Products','noo')         => 'recent',
                    esc_html__('Featured products','noo')       => 'featured',
                    esc_html__('Best Selling Products','noo')   => 'selling',
                    esc_html__('Sale Products','noo')           => 'sale',
                    esc_html__('Categories','noo')              => 'cat',
                )
            ),
            array(
                'type'          =>  'noo_product_cat',
                'heading'       =>  esc_html__('Choose Categories','noo'),
                'description'   =>  esc_html__('Display product in categories','noo'),
                'holder'        =>  $holder,
                'dependency'    =>  Array('element' =>  'data', 'value'   =>  'cat'),
                'param_name'    =>  'cat'
            ),
            array(
                'param_name'  => 'orderby',
                'heading'     => esc_html__( 'Order By', 'noo' ),
                'description' => '',
                'type'        => 'dropdown',
                'holder'      => $holder,
                'value'       => array(
                    esc_html__( 'Recent First', 'noo' )             => 'latest',
                    esc_html__( 'Older First', 'noo' )              => 'oldest',
                    esc_html__( 'Title Alphabet', 'noo' )           => 'alphabet',
                    esc_html__( 'Title Reversed Alphabet', 'noo' )  => 'ralphabet' )
            ),
            array(
                'param_name'  => 'columns',
                'heading'     => esc_html__( 'Product Columns', 'noo' ),
                'description' => '',
                'type'        => 'dropdown',
                'holder'      => $holder,
                'value'       => array(
                    esc_html__( '3 Columns', 'noo' )     => '3',
                    esc_html__( '4 Columns', 'noo' )     => '4',
                    esc_html__( '2 Columns', 'noo' )     => '2'
                )
            ),
            array(
                'param_name'    =>  'limit_excerpt',
                'heading'       =>  esc_html__('Limit excerpt', 'noo'),
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'value'         =>  20
            ),
            array(
                'param_name'    =>  'posts_per_page',
                'heading'       =>  esc_html__('Posts per page', 'noo'),
                'description'   =>  esc_html__('The "per_page" shortcode determines how many products to show on the page', 'noo'),
                'type'          =>  'textfield',
                'holder'        =>  $holder
            )
        )
    ));

    // noo_product_countdown
    vc_map(array(
        'base'        => 'noo_product_countdown',
        'name'        => __( 'Product Countdown', 'noo' ),
        'class'       => 'noo-icon-countdown',
        'icon'        => 'noo-icon-countdown',
        'category'    => $category_name,
        'description' => '',
        'params'      => array(
            array(
                'param_name'  => 'date',
                'heading'     => __( 'Choose date', 'noo' ),
                'description' => '',
                'type'        => 'noo_datepicker',
                'format'      => 'mm/dd/yy',
                'admin_label' => true,
                'holder'      => $holder
            ),
            array(
                'type'          => 'autocomplete',
                'heading'       => esc_html__( 'Select identificator', 'noo' ),
                'param_name'    => 'id',
                'admin_label'   => true,
                'holder'        => $holder,
                'description'   => esc_html__( 'Input product ID or product SKU or product title to see suggestions', 'noo' ),
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Choose style', 'noo' ),
                'param_name'    => 'style',
                'admin_label'   => true,
                'holder'        => $holder,
                'value'         =>  array(
                    esc_html__('Default','noo')   =>  'default',
                    esc_html__('White','noo')     =>  'style_white'
                )
            )
        )
    ));

    if( class_exists('Vc_Vendor_Woocommerce') ):
        $product_Woocommerce2 = new Vc_Vendor_Woocommerce();
        //Filters For autocomplete param:
        //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
        add_filter( 'vc_autocomplete_noo_product_countdown_id_callback', array(
            $product_Woocommerce2,
            'productIdAutocompleteSuggester'
        ), 10, 1 ); // Get suggestion(find). Must return an array
        add_filter( 'vc_autocomplete_noo_product_countdown_id_render', array(
            $product_Woocommerce2,
            'productIdAutocompleteRender'
        ), 10, 1 ); // Render exact product. Must return an array (label,value)
        //For param: ID default value filter
        add_filter( 'vc_form_fields_render_field_noo_product_countdown_id_param_value', array(
            $product_Woocommerce2,
            'productIdDefaultValue'
        ), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.
    endif;


    //[noo_product_menu]
    vc_map(array(
        'name'          =>  esc_html__('Noo Products Menu','noo'),
        'base'          =>  'noo_product_menu',
        'description'   =>  esc_html__('Display Product','noo'),
        'icon'          =>  'noo_list_icon',
        'category'      =>   $category_name,
        'params'        =>  array(
            array(
                'type'          => 'attach_image',
                'heading'       => esc_html__( 'Icon', 'noo' ),
                'param_name'    => 'icon',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__( 'Attach', 'noo' ),
                'param_name'    => 'attach',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__( 'Title', 'noo' ),
                'param_name'    => 'title',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          => 'textarea',
                'heading'       => esc_html__( 'Description', 'noo' ),
                'param_name'    => 'description',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          =>  'noo_product_cat',
                'heading'       =>  esc_html__('Choose Categories','noo'),
                'description'   =>  esc_html__('Display product in categories','noo'),
                'holder'        =>  $holder,
                'param_name'    =>  'cat'
            ),
            array(
                'param_name'  => 'orderby',
                'heading'     => esc_html__( 'Order By', 'noo' ),
                'description' => '',
                'type'        => 'dropdown',
                'holder'      => $holder,
                'value'       => array(
                    esc_html__( 'Recent First', 'noo' )             => 'latest',
                    esc_html__( 'Older First', 'noo' )              => 'oldest',
                    esc_html__( 'Title Alphabet', 'noo' )           => 'alphabet',
                    esc_html__( 'Title Reversed Alphabet', 'noo' )  => 'ralphabet' )
            ),
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Limit','noo'),
                'param_name'    =>  'posts_per_page',
                'value'         =>  10
            ),
            array(
                'type'          => 'attach_image',
                'heading'       => esc_html__( 'Background', 'noo' ),
                'param_name'    => 'background',
                'admin_label'   => true,
                'holder'        => $holder
            )
        )
    ));


//[product_simple_slider]
    vc_map(array(
        'name'          =>  esc_html__('Product Simple Slider','noo'),
        'base'          =>  'product_simple_slider',
        'description'   =>  esc_html__('Display product by slider','noo'),
        'icon'          =>  'noo_icon_slider',
        'category'      =>   $category_name,
        'params'        =>  array(
            array(
                'type'          =>  'noo_product_cat',
                'heading'       =>  esc_html__('Choose Categories','noo'),
                'description'   =>  esc_html__('Display product in categories','noo'),
                'holder'        =>  $holder,
                'param_name'    =>  'cat'
            ),
            array(
                'param_name'  => 'orderby',
                'heading'     => esc_html__( 'Order By', 'noo' ),
                'description' => '',
                'type'        => 'dropdown',
                'holder'      => $holder,
                'value'       => array(
                    esc_html__( 'Recent First', 'noo' )             => 'latest',
                    esc_html__( 'Older First', 'noo' )              => 'oldest',
                    esc_html__( 'Title Alphabet', 'noo' )           => 'alphabet',
                    esc_html__( 'Title Reversed Alphabet', 'noo' )  => 'ralphabet' )
            ),
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Limit','noo'),
                'param_name'    =>  'posts_per_page',
                'value'         =>  10
            ),
            array(
                'type'          =>  'dropdown',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Config columns slider','noo'),
                'param_name'    =>  'columns',
                'value'         =>  array(
                    esc_html__('3 columns','noo')     =>  '3',
                    esc_html__('5 columns','noo')     =>  '5',
                    esc_html__('4 columns','noo')     =>  '4',
                    esc_html__('2 columns','noo')     =>  '2',
                    esc_html__('1 columns','noo')     =>  '1'
                )
            ),
            array(
                'type'          =>  'dropdown',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Auto Slider','noo'),
                'param_name'    =>  'auto_slider',
                'value'         =>  array(
                    esc_html__('False','noo')     =>  'false',
                    esc_html__('True','noo')     =>  'true'
                )
            )
        )
    ));

    //[noo_product_list]
    vc_map(array(
        'name'      =>  esc_html__('Noo Product list','noo'),
        'base'      =>  'noo_product_list',
        'description'   =>  esc_html__('Display post type product','noo'),
        'icon'      =>  'noo_icon_list',
        'category'  =>   $category_name,
        'params'    =>  array(
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Title','noo'),
                'param_name'    =>  'title',
                'value'         =>  ''
            ),
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Description','noo'),
                'param_name'    =>  'description',
                'value'         =>  ''
            ),
            array(
                'type'          =>  'noo_product_cat',
                'heading'       =>  esc_html__('Choose Categories','noo'),
                'description'   =>  esc_html__('Display product in categories','noo'),
                'holder'        =>  $holder,
                'param_name'    =>  'cat'
            ),
            array(
                'param_name'  => 'orderby',
                'heading'     => esc_html__( 'Order By', 'noo' ),
                'description' => '',
                'type'        => 'dropdown',
                'holder'      => $holder,
                'value'       => array(
                    esc_html__( 'Recent First', 'noo' )             => 'latest',
                    esc_html__( 'Older First', 'noo' )              => 'oldest',
                    esc_html__( 'Title Alphabet', 'noo' )           => 'alphabet',
                    esc_html__( 'Title Reversed Alphabet', 'noo' )  => 'ralphabet' )
            ),
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Limit','noo'),
                'param_name'    =>  'posts_per_page',
                'value'         =>  10
            ),
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Button Name','noo'),
                'param_name'    =>  'button_name',
                'value'         =>  ''
            ),
            array(
                'type'          =>  'textfield',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Button Link','noo'),
                'param_name'    =>  'button_link',
                'value'         =>  '#'
            ),
        )
    ));

// Noo countdown
    vc_map(array(
        'base'        => 'noo_simple',
        'name'        => __( 'Product simple', 'noo' ),
        'class'       => 'noo-icon-simple',
        'icon'        => 'icon-wpb-ui-button',
        'category'    => $category_name,
        'description' => '',
        'params'      => array(
            array(
                'type'          => 'attach_image',
                'heading'       => esc_html__( 'Icon', 'noo' ),
                'param_name'    => 'icon',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__( 'Attach', 'noo' ),
                'param_name'    => 'attach',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__( 'Title', 'noo' ),
                'param_name'    => 'title',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          => 'textarea',
                'heading'       => esc_html__( 'Description', 'noo' ),
                'param_name'    => 'description',
                'admin_label'   => true,
                'holder'        => $holder
            ),
            array(
                'type'          => 'autocomplete',
                'heading'       => esc_html__( 'Select identificator', 'noo' ),
                'param_name'    => 'id',
                'admin_label'   => true,
                'holder'        => $holder,
                'description'   => esc_html__( 'Input product ID or product SKU or product title to see suggestions', 'noo' ),
            ),
            array(
                'type'          =>  'attach_image',
                'holder'        =>  $holder,
                'class'         =>  '',
                'heading'       =>  esc_html__('Background','noo'),
                'param_name'    =>  'background',
                'value'         =>  ''
            ),
        )
    ));


    if( class_exists('Vc_Vendor_Woocommerce') ):
        $product_Woocommerce3 = new Vc_Vendor_Woocommerce();
        //Filters For autocomplete param:
        //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
        add_filter( 'vc_autocomplete_noo_simple_id_callback', array(
            $product_Woocommerce3,
            'productIdAutocompleteSuggester'
        ), 10, 1 ); // Get suggestion(find). Must return an array
        add_filter( 'vc_autocomplete_noo_simple_id_render', array(
            $product_Woocommerce3,
            'productIdAutocompleteRender'
        ), 10, 1 ); // Render exact product. Must return an array (label,value)
        //For param: ID default value filter
        add_filter( 'vc_form_fields_render_field_noo_simple_id_param_value', array(
            $product_Woocommerce3,
            'productIdDefaultValue'
        ), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.
    endif;
}