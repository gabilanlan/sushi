<?php
    if( !function_exists('noo_shortcode_image') ){

        function noo_shortcode_image($atts){
            extract(shortcode_atts(array(
                'image'     =>  '',
                'link'      =>  '#',
                'height'    =>  '840'
            ),$atts));
            ob_start();
            $url_img = '';
            if( isset($image) && !empty($image) ){
                $url_img = wp_get_attachment_image_src(esc_attr($image),'full');
            }
            ?>
             <a href="<?php echo esc_url($link); ?>">
                <div class="noo-image" <?php if( isset($url_img) && !empty($url_img) ): ?> style="height: <?php echo esc_attr($height).'px'; ?> ;background-image: url('<?php echo esc_url($url_img[0]); ?>')" <?php endif; ?>>
                    <div class="noo-line">
                        <span class="line-one">
                            <span></span>
                            <span></span>
                        </span>
                        <span class="line-two">
                            <span></span>
                            <span></span>
                        </span>
                    </div>
                </div>
             </a>
            <?php
            $img = ob_get_contents();
            ob_end_clean();
            return $img;
        }
        add_shortcode('noo_image','noo_shortcode_image');

    }