<?php

    if( !function_exists('noo_shortcode_custom_countdown') ){

        function noo_shortcode_custom_countdown($atts){
            extract(shortcode_atts(array(
                'link'          =>      '#',
                'date'          =>      '',
                'icon'          =>      '',
                'attach'        =>      '',
                'title'         =>      '',
                'description'   =>      '',
                'price'         =>      '',
                'image'         =>      '',
            ),$atts));

            wp_enqueue_script('vendor-countdown-plugin');
            wp_enqueue_script('vendor-countdown-js');

            ob_start();

            $date_time = '';
            if( isset($date) && $date != '' ){
                $date_time = explode('/',$date);
            }
            esc_html__('ehe','noo');
            ?>
            <div class="custom_countdown_wrap">
                <a href="<?php echo esc_url($link); ?>">
                    <?php if(isset( $icon ) && !empty( $icon )): echo wp_get_attachment_image( esc_attr($icon),'',false,array('class'=>'icon') ); endif;?>
                    <?php if( isset($attach) && !empty($attach) ): ?><h4><?php echo esc_html($attach); ?></h4><?php endif; ?>
                    <?php if( isset($title) && !empty($title) ): ?><h2><?php echo esc_html($title); ?></h2><?php endif; ?>
                    <?php if( isset($description) && !empty($description) ): ?><p class="ds"><?php echo esc_html($description); ?></p><?php endif; ?>
                    <?php if( isset($price) && !empty($price) ): ?><p class="price"><?php echo wp_kses($price,array('em'=>array())); ?></p><?php endif; ?>
                    <div class="noo_custom_countdown"></div>
                    <?php if(isset( $image ) && !empty( $image )): echo wp_get_attachment_image( esc_attr($image),'full',false,array('class'=>'thumb') ); endif;?>
                </a>
            </div>
            <script>
                jQuery(document).ready(function(){
                    austDay = new Date(<?php if( isset($date_time) && $date_time[2] !=''){ echo esc_attr($date_time[2]); } ?>, <?php if( isset($date_time) && $date_time[0] !=''){ echo esc_attr($date_time[0]); } ?> - 1,  <?php if( isset($date_time) && $date_time[1] !=''){ echo esc_attr($date_time[1]); } ?>);
                    jQuery('.noo_custom_countdown').countdown({labels: ['<?php echo esc_html__('Years','noo') ?>', '<?php echo esc_html__('Months','noo') ?>', '<?php echo esc_html__('Weeks','noo') ?>', '<?php echo esc_html__('Days','noo') ?>', '<?php echo esc_html__('Hours','noo') ?>', '<?php echo esc_html__('Minutes','noo') ?>', '<?php echo esc_html__('Seconds','noo') ?>'],until: austDay});
                    jQuery('#year').text(austDay.getFullYear());
                });
            </script>
            <?php
            $c_content = ob_get_contents();
            ob_end_clean();
            return $c_content;
        }
        add_shortcode('noo_custom_countdown','noo_shortcode_custom_countdown');

    }