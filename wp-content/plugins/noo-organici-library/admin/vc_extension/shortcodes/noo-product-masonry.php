<?php

/* *
 * This is shortcode display product by style masonry
 */

if( !function_exists('noo_shortcode_product_masonry') ){

    function noo_shortcode_product_masonry($atts){
        extract(shortcode_atts(array(
            'title'             =>  '',
            'description'       =>  '',
            'data'              =>  'recent',
            'cat'               =>  '',
            'posts_per_page'    =>  10,
            'limit_excerpt'     =>  20,
            'columns'           =>  '3',
            'orderby'           =>  'date'
        ),$atts));
        ob_start();
        wp_enqueue_script('vendor-imagesloaded');
        wp_enqueue_script('isotope');
        wp_enqueue_script('portfolio');
        ?>
            <?php if( $title != '' || $description !='' ): ?>
                <div class="noo-sh-title">
                    <?php if( isset($title) && !empty($title) ) ?><h2><?php echo esc_html($title);  ?></h2>
                    <?php if( isset($description) && !empty($description) ): ?><p><?php echo esc_html($description); ?></p><?php endif; ?>
                </div>
            <?php endif; ?>
        <?php
        $order = 'DESC';
        switch ($orderby) {
            case 'latest':
                $orderby = 'date';
                break;

            case 'oldest':
                $orderby = 'date';
                $order = 'ASC';
                break;

            case 'alphabet':
                $orderby = 'title';
                $order = 'ASC';
                break;

            case 'ralphabet':
                $orderby = 'title';
                break;

            default:
                $orderby = 'date';
                break;
        }
        $args = array(
            'post_type'				=> 'product',
            'post_status'			=> 'publish',
            'ignore_sticky_posts'	=> 1,
            'posts_per_page' 		=> $posts_per_page,
            'orderby' 				=> $orderby,
            'order' 				=> $order,
        );

        switch( $data ):
            case 'featured':
                $args['meta_query'][] = array(
                    'key'   => '_featured',
                    'value' => 'yes'
                );
                break;
            case 'selling':
                $args['meta_key']            = 'total_sales';
                $args['orderby']             = 'meta_value_num';
                break;
            case 'sale':
                if( function_exists('wc_get_product_ids_on_sale') ):
                    $product_ids_on_sale = wc_get_product_ids_on_sale();
                    $args['post__in']	 = array_merge( array( 0 ), $product_ids_on_sale );
                endif;
                break;
            case 'cat':
                if( isset($cat) && $cat != 'all' && !empty($cat) ){
                    $new_id = explode(',',$cat);
                    $new_cat = array();
                    foreach($new_id as $id){
                        $new_cat[] = intval($id);
                    }
                    $args['tax_query'][] = array(
                        'taxonomy'  =>  'product_cat',
                        'field'     =>  'term_id',
                        'terms'     =>   $new_cat
                    );
                }

                break;
        endswitch;

        $products = new WP_Query($args);
        if( $products->have_posts() ):
            echo '<div class="noo-product-masonry columns-'.esc_attr($columns).'">';
                while( $products->have_posts() ): $products->the_post(); ?>
                    <div class="product-masonry">
                        <?php the_post_thumbnail('large'); ?>
                        <div class="noo-link">
                            <div class="noo-product-table">
                                <div class="noo-product-table-cell">
                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a></h4>
                                    <p><?php echo wp_trim_words(get_the_excerpt(),esc_attr($limit_excerpt)); ?></p>
                                    <span class="noo-sh-pmeta">
                                        <?php do_action('noo_organici-sh-addtocart'); ?>
                                        <a class="fa fa-link" href="<?php the_permalink(); ?>"></a>
                                    </span>
                                </div>
                            </div>
                        </div><!--end .noo-link-->
                    </div>
               <?php endwhile;
            echo '</div>';
        endif; wp_reset_postdata(); ?>
        <?php
        $masonry = ob_get_contents();
        ob_end_clean();
        return $masonry;
    }
    add_shortcode('noo_product_masonry','noo_shortcode_product_masonry');

}