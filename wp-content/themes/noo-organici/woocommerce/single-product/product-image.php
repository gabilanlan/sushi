<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post, $product;
$attachment_ids = $product->get_gallery_image_ids();
?>
<div class="images">

	<?php
        if(isset($attachment_ids) && !empty($attachment_ids)):
            wp_enqueue_script('noo-carousel');
            if( has_post_thumbnail()){
                array_unshift($attachment_ids,get_post_thumbnail_id());

            }

        ?>
            <div class="project-slider">
                <div class="owl-carousel sync1">
                    <?php
                    foreach($attachment_ids as $id ):
                        $image_link = wp_get_attachment_image_src($id,'full');
                        echo '<div class="item">'; ?>
                        <a href="<?php echo esc_url($image_link[0]) ?>" class="woocommerce-main-image zoom" title="<?php echo esc_attr(get_the_title($id)); ?>" rel="prettyPhoto[product-gallery]">
                            <?php echo wp_get_attachment_image( esc_attr($id),'full'); ?>
                        </a>
                        <?php echo '</div>';
                    endforeach;
                    ?>
                </div>
                <div class="owl-carousel sync2">
                    <?php
                    foreach($attachment_ids as $id ):
                        echo '<div class="item">';
                        echo wp_get_attachment_image( esc_attr($id) );
                        echo '</div>';
                    endforeach;
                    ?>
                </div>
            </div>
            <script>
                jQuery(document).ready(function(){
                    var sync1 = jQuery(".sync1");
                    var sync2 = jQuery(".sync2");

                    sync1.owlCarousel({
                        singleItem : true,
                        slideSpeed : 1000,
                        navigation: false,
                        pagination:false,
                        autoHeight : true,
                        responsiveRefreshRate : 200
                    });

                    sync2.owlCarousel({
                        items : 4,
                        itemsDesktop      : [1199,4],
                        itemsDesktopSmall     : [979,4],
                        itemsTablet       : [768,3],
                        itemsMobile       : [479,2],
                        pagination:false,
                        responsiveRefreshRate : 100
                    });

                    sync2.on("click", ".owl-item", function(e){
                        e.preventDefault();
                        var number = jQuery(this).data("owlItem");
                        sync1.trigger("owl.goTo",number);
                    });
                });
            </script>
        <?php
        else:
		if ( has_post_thumbnail() ) {

			$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
			$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
			$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	=> $image_title,
				'alt'	=> $image_title
				) );

			$attachment_count = 0;

            $gallery = '';

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="product-simple-image"><a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" rel="prettyPhoto' . $gallery . '">%s</a></div>', $image_link, $image_caption, $image ), $post->ID );

		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_html__( 'Placeholder', 'noo-organici' ) ), $post->ID );

		}
    endif;
	?>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("a.woocommerce-main-image[rel]").prettyPhoto();
        });
    </script>
</div>
