<?php

    if( !function_exists('noo_shortcode_product_countdown')){

        function noo_shortcode_product_countdown($atts){
            extract(shortcode_atts(array(
                'date'              =>  '',
                'id'                =>  '',
                'style'             =>  'default'
            ),$atts));
            ob_start();
            wp_enqueue_script('vendor-countdown-plugin');
            wp_enqueue_script('vendor-countdown-js');
            if( $id == '' ){
                return false;
            }
            $date_time = '';
            if( isset($date) && $date != '' ){
                $date_time = explode('/',$date);
            }
            $args = array(
                'post_type' => 'product',
                'p'         => esc_attr($id)
            );
            add_action('noo_countdown_product','woocommerce_template_loop_price');
            add_action('noo_countdown_product','noo_organici_product_single_excerpt');
            add_action('noo_countdown_product','woocommerce_template_single_meta');
            $query = new WP_Query( $args );
            if( $query->have_posts() ): ?>
                <div class="noo-countdown-product <?php echo esc_attr($style) ?>">
                <?php while( $query->have_posts() ):
                        $query->the_post(); ?>

                            <h3>
                                <a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>

                            <?php do_action('noo_countdown_product'); ?>

                            <div class="defaultCountdown hide_name"></div>

                            <?php if(function_exists('noo_organici_template_loop_add_to_cart')):  noo_organici_template_loop_add_to_cart(get_the_ID()); endif; ?>
                    <?php  endwhile;  ?>
                    <script>
                        jQuery(document).ready(function(){
                            austDay = new Date(<?php if( isset($date_time) && $date_time[2] !=''){ echo esc_attr($date_time[2]); } ?>, <?php if( isset($date_time) && $date_time[0] !=''){ echo esc_attr($date_time[0]); } ?> - 1,  <?php if( isset($date_time) && $date_time[1] !=''){ echo esc_attr($date_time[1]); } ?>);
                            jQuery('.defaultCountdown').countdown({labels: ['<?php echo esc_html__('Years','noo') ?>', '<?php echo esc_html__('Months','noo') ?>', '<?php echo esc_html__('Weeks','noo') ?>', '<?php echo esc_html__('Days','noo') ?>', '<?php echo esc_html__('Hours','noo') ?>', '<?php echo esc_html__('Minutes','noo') ?>', '<?php echo esc_html__('Seconds','noo') ?>'],until: austDay});
                            jQuery('#year').text(austDay.getFullYear());
                        });
                    </script>
                </div><!--end .noo-countdown-product-->
            <?php endif; wp_reset_postdata(); ?>
            <?php
            $countdown = ob_get_contents();
            ob_end_clean();
            return $countdown;


        }
        add_shortcode('noo_product_countdown','noo_shortcode_product_countdown');

    }