<?php

    if( !function_exists('noo_shortcode_represent_product') ){

        function noo_shortcode_represent_product($atts){
            extract(shortcode_atts(array(
                'icon'         =>  '',
                'title'        =>  '',
                'description'  =>  '',
                'button_name'  =>  '',
                'button_link'  =>  '#'
            ),$atts));
            ob_start();
            ?>
                <div class="noo-represent">
                    <?php
                        if( isset($icon) && !empty($icon) ):
                            echo wp_get_attachment_image(esc_attr($icon),'full');
                        endif;
                    ?>
                    <?php if( isset($title) && !empty($title) ): ?><h2><?php echo esc_html($title); ?></h2><?php endif; ?>
                    <?php if( isset($description) && !empty($description) ): ?><p><?php echo esc_html($description); ?></p><?php endif; ?>
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
            <?php
            $represent = ob_get_contents();
            ob_end_clean();
            return $represent;

        }
        add_shortcode('noo_represent_product','noo_shortcode_represent_product');

    }