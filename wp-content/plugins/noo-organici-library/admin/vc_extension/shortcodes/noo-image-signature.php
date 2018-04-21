<?php
    if( !function_exists('noo_shortcode_image_signature') ):
        function noo_shortcode_image_signature($atts){
            extract(shortcode_atts(array(
                'image'            =>  '',
                'background_color' =>  '',
                'signature'        =>  '',
                'name'             =>  '',
                'position'         =>  '',
            ),$atts));
            ob_start();
            ?>
                <div class="noo-image-signature">
                    <div class="img-background-color" style="background-color: <?php echo esc_attr($background_color); ?>"></div>
                    <?php
                        $url_img = wp_get_attachment_image_src(esc_attr($image),'full');
                    ?>
                    <div class="img-background-sign" style="background-image: url(<?php echo esc_url($url_img[0]); ?>);"></div>
                    
                    <div class="pull-left img-sign">
                        <?php if( isset($signature) && !empty($signature) ):
                           echo wp_get_attachment_image(esc_attr($signature),'full');
                       endif; ?>
                    </div>
                    <div class="pull-left">
                        <?php if( isset($name) && !empty($name) ) ?><h6><?php echo esc_html($name);  ?></h6>
                        <?php if( isset($position) && !empty($position) ) ?><span><?php echo esc_html($position);  ?></span>
                    </div>
                </div>
            <?php
            $image_signature = ob_get_contents();
            ob_end_clean();
            return $image_signature;
        }
        add_shortcode('noo_image_signature','noo_shortcode_image_signature');
    endif;