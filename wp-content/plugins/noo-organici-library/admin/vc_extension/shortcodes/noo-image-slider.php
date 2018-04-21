<?php

    if( !function_exists('noo_shortcode_image_slider') ){

        function noo_shortcode_image_slider($atts){
            extract(shortcode_atts(array(
                'slider'         =>  '',
                'auto_slider'    =>  'false',
                'padding'        =>  '',
                'columns'        =>  '3'
            ),$atts));
            ob_start();
            wp_enqueue_script('noo-carousel');

            $id = uniqid('noo_image_slider_');

            if( isset($slider) && !empty($slider) ): ?>
                <div class="noo-slider-wrap <?php echo esc_attr($id) ?>">
                    <ul class="noo-slider-image<?php echo esc_attr($padding) ?>">
                      <?php
                      $new_slider = vc_param_group_parse_atts( $slider );
                      if( isset($new_slider) && !empty($new_slider) ){
                          foreach( $new_slider as $slider ):
                          ?>
                            <li>
                                <div class="image-style">
                                    <a href="<?php if( isset($slider['link']) && !empty($slider['link']) ) echo esc_url($slider['link']) ?>">
                                        <?php if( isset($slider['image']) && !empty($slider['image']) ):
                                            echo wp_get_attachment_image($slider['image'],'full');
                                         endif; ?>
                                    </a>
                                </div>
                            </li>
                        <?php
                            endforeach;
                         } ?>
                    </ul>
                </div>


            <?php endif; ?>
            <script>
                jQuery(document).ready(function(){
                    jQuery('.<?php echo esc_attr($id)?> .noo-slider-image').owlCarousel({
                        items : <?php echo esc_attr($columns) ?>,
                        itemsDesktop : [1199,<?php echo esc_attr($columns) ?>],
                        itemsDesktopSmall : [991,2],
                        itemsTablet: [768, 1],
                        slideSpeed:500,
                        paginationSpeed:800,
                        rewindSpeed:1000,
                        autoHeight: true,
                        addClassActive: true,
                        autoPlay: <?php echo esc_attr($auto_slider) ?>,
                        loop:true,
                        pagination: false
                    });
                });
            </script>
            <?php
            $slider = ob_get_contents();
            ob_end_clean();
            return $slider;

        }
        add_shortcode('noo_image_slider','noo_shortcode_image_slider');

    }