<?php
    if( !function_exists('noo_shortcode_title') ):
        function noo_shortcode_title($atts){
            extract(shortcode_atts(array(
                'title'             =>  '',
                'description'       =>  ''
            ),$atts));
            ob_start();
            ?>
                <?php if( $title != '' || $description !='' ): ?>
                    <div class="noo-sh-title noo-blog-title">
                        <?php if( isset($title) && !empty($title) ) ?><h2><?php echo esc_html($title);  ?></h2>
                        <?php if( isset($description) && !empty($description) ): ?><p><?php echo esc_html($description); ?></p><?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php
            $noo_title = ob_get_contents();
            ob_end_clean();
            return $noo_title;
        }
        add_shortcode('noo_title','noo_shortcode_title');
    endif;