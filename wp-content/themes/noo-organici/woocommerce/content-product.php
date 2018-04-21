<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;


$grid_columns = noo_organici_woocommerce_shop_columns();

if( !is_product() ):
    // Ensure visibility
    if ( ! $product || ! $product->is_visible() ) {
        return;
    }
endif;


// Extra post classes
$classes = array();
$term_cat = get_the_terms(get_the_ID(), 'product_cat');
if( isset($term_cat) && !empty($term_cat) ){
    foreach($term_cat as $term):
        $classes[] = $term->slug;
    endforeach;
}
$classes[] = 'masonry-item';


$product_layout = noo_organici_get_option( 'noo_shop_layout', 'fullwidth' );
// if( $product_layout == 'fullwidth' ){
    if( $grid_columns == 4 ){
        $classes[] = 'noo-product-column noo-md-3 noo-sm-6';
    }elseif ( $grid_columns == 2 ) {
        $classes[] = 'noo-product-column noo-md-6 noo-sm-6';
    } elseif ( $grid_columns == 1 ) {
        $classes[] = 'noo-product-column noo-md-12 noo-sm-12';
    } else {
        $classes[] = 'noo-product-column noo-md-4 noo-sm-6';
    }
// } 
// else {
//     if( $grid_columns == 4 ){
//         $classes[] = 'noo-product-column noo-md-3 noo-sm-6';
//     }elseif ( $grid_columns == 2 ) {
//         $classes[] = 'noo-product-column noo-md-6 noo-sm-6';
//     } elseif ( $grid_columns == 1 ) {
//         $classes[] = 'noo-product-column noo-md-12 noo-sm-12';
//     } else {
//         $classes[] = 'noo-product-column noo-md-4 noo-sm-6';
//     }
// }

?>
<div <?php post_class( $classes ); ?>>
    <div class="noo-product-inner">
        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
        <a href="<?php the_permalink(); ?>" class="noo-link-thumbail">

            <?php
                /**
                 * woocommerce_before_shop_loop_item_title hook
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                do_action( 'woocommerce_before_shop_loop_item_title' );



            ?>

        </a>

        <?php
        echo '<div class="noo-product-title">';
        /**
         * woocommerce_shop_loop_item_title hook
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
      //  do_action( 'woocommerce_shop_loop_item_title' );
        ?>
        <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
        <?php

        /**
         * woocommerce_after_shop_loop_item_title hook
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action( 'woocommerce_after_shop_loop_item_title' );
        echo '</div>';

            /**
             * woocommerce_after_shop_loop_item hook
             *
             * @hooked woocommerce_template_loop_add_to_cart - 10
             */
//            do_action( 'woocommerce_after_shop_loop_item' );

        ?>
    </div>
</div>
