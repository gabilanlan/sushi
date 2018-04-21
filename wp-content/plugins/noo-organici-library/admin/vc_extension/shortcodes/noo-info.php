<?php

    if( !function_exists('noo_shortcode_info') ){

        function noo_shortcode_info($atts){
            extract(shortcode_atts(array(
                'icon'      =>  '',
                'number'    =>  '',
                'title'     =>  '',
                'desc'      =>  '',
                'css'       => '',
                'position'  =>  '',
                'color'     =>  'noo-green'
            ),$atts));
            $css_class = vc_shortcode_custom_css_class( $css, ' ' );
            ob_start();
            ?>
                <div class="noo-info <?php echo esc_attr( $css_class ) . ' '. esc_attr($color). esc_attr($position); ?>">
                    <?php if( isset($icon) && !empty($icon) ):
                        echo wp_get_attachment_image(esc_attr($icon),'full','',array('class'=>'noo-info-icon'));
                    endif; ?>
                    <div class="noo-info-content">
                        <strong><?php echo esc_html($number); ?></strong>
                        <h5><?php echo esc_html($title); ?></h5>
                        <p><?php echo esc_html($desc); ?></p>
                    </div>
                </div>
            <?php
            $info = ob_get_contents();
            ob_end_clean();
            return $info;

        }
        add_shortcode('noo_info','noo_shortcode_info');
    }