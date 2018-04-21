<?php

    if( !function_exists('noo_product_simple') ){

        function noo_product_simple($atts){
            extract(shortcode_atts(array(
                'icon'              =>  '',
                'attach'            =>  '',
                'title'             =>  '',
                'description'       =>  '',
                'id'                =>  '',
                'background'        =>  ''
            ),$atts));
            ob_start();
            if( $id == '' ){
                return false;
            }
            add_action('noo_simple_slider_product','woocommerce_template_loop_price');
            add_action('noo_simple_slider_product','noo_organici_product_single_excerpt');
            add_action('noo_simple_slider_product','woocommerce_template_single_meta');
            $args = array(
                'post_type' => 'product',
                'p'         => esc_attr($id)
            );
            $query = new WP_Query($args);
            $image = '';
            if( isset($background) && !empty($background) ){
                $image = wp_get_attachment_image_src($background,'full');
            }
            ?>
            <?php if( !empty($title) || !empty($icon) || !empty($attach) || !empty($description)  ): ?>
            <div class="inheader-sh-title creative-product-title">
                <?php if(isset( $icon ) && !empty( $icon )): echo wp_get_attachment_image( esc_attr($icon),'',false,array('class'=>'icon') ); endif;?>
                <?php if( isset($title) && !empty($title) ): ?><h2><?php echo esc_html($title); ?></h2><?php endif; ?>
                <?php if( isset($attach) && !empty($attach) ): ?><h4><?php echo esc_html($attach); ?></h4><?php endif; ?>
                <?php if( isset($description) && !empty($description) ): ?><p class="ds"><?php echo esc_html($description); ?></p><?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="noo-creative-product-slider">
                <div class="noo-simple-product-bk" <?php if( isset($image) && !empty($image) ): ?> style="background-image: url('<?php echo esc_url($image[0]) ; ?>')" <?php endif; ?>></div>
                <?php
                if( $query->have_posts() ):
                    while( $query->have_posts() ):
                        $query->the_post();
                        ?>
                        <div class="noo-simple-slider-img">
                            <?php the_post_thumbnail(); ?>
                        </div>
                            <div class="noo-container">
                                <div class="noo-row">
                                    <div class="noo-md-6 pull-right">
                                        <div class="noo-simple-slider-content">
                                            <h3> <a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>
                                            <?php do_action('noo_simple_slider_product'); ?>
                                            <?php if(function_exists('noo_organici_template_loop_add_to_cart')):  noo_organici_template_loop_add_to_cart(get_the_ID()); endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    endwhile;
                endif;
                ?>
            </div>

            <?php
            $slider = ob_get_contents();
            ob_end_clean();
            return $slider;
        }
        add_shortcode('noo_simple','noo_product_simple');
    }