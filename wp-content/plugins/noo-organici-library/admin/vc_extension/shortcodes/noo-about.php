<?php

    if( !function_exists('noo_shortcode_about') ){

        function noo_shortcode_about($atts){
            extract(shortcode_atts(array(
                'background_left'   =>  '',
                'icon'              =>  '',
                'description'       =>  '',
                'button_name'       =>  '',
                'button_link'       =>  ''
            ),$atts));
            ob_start();
            $img = wp_get_attachment_image_src($background_left,'full');
            ?>
                <div class="noo-about-wrap">
                    <div class="noo-about-left" style="background-image: url('<?php echo esc_url($img[0]); ?>')"></div>
                    <div class="noo-about-right">
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
                        <?php echo  wp_get_attachment_image( esc_attr($icon),'full'); ?>
                        <p><?php echo esc_html($description); ?>
                        </p>
                        <?php if( isset($button_name) && !empty($button_name) ): ?>
                        <div class="noo-button-creative">
                            <a href="<?php echo esc_url($button_link); ?>">
                                <span class="first"></span>
                                <span class="second"></span>
                                <?php echo esc_html($button_name) ?>
                                <span class="three"></span>
                                <span class="four"></span>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php


            $about = ob_get_contents();
            ob_end_clean();
            return $about;

        }
        add_shortcode('noo_about','noo_shortcode_about');

    }