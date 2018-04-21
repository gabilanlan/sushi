<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */
?>
<?php

	wp_enqueue_script('vendor-imagesloaded');
    wp_enqueue_script('isotope');
    wp_enqueue_script('portfolio');

    $porduct_layout = noo_organici_get_option('noo_shop_default_layout','grid');
    $display_layout = $rtl = '';
    $product_class  = 'product-grid noo-product-grid';
    if( $porduct_layout != 'grid' ){
        $product_class  = 'product-list';
    }
    if(is_shop()){
	    $display_layout = 'data-layout='.noo_organici_get_option('noo_shop_display_style','fitRows');
	    
	}
	// Related Products
	if(is_product()){
		wp_enqueue_script('noo-carousel');
		wp_enqueue_style('owl_carousel');
		$product_class = 'owl-carousel product-grid';
		$display_layout = 'data-layout='.noo_organici_get_option('noo_shop_grid_column',4);
		if(is_rtl()) $display_layout .= ' data-rtl = true';
	}
?>
<div class="products noo-row <?php echo esc_attr($product_class); ?>" <?php echo esc_attr($display_layout);?>>