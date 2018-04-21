<?php


    function noo_shortcode_atributes($atts,$content=null){
        extract(shortcode_atts(array(
            'image' =>  ''
        ),$atts));
        ob_start();
        ?>
            <div class="noo-atributes">
                <?php echo wp_get_attachment_image(esc_attr($image),'full'); ?>
                <?php echo do_shortcode($content); ?>
            </div>
        <?php

        $atributes = ob_get_contents();
        ob_end_clean();
        return $atributes;
    }
    add_shortcode('noo_atributes','noo_shortcode_atributes');


    function noo_atributes_shortcode_item($atts){
        extract(shortcode_atts(array(
            'title'         =>  '',
            'link'          =>  '#',
            'description'   =>  '',
            'icon'          =>  '',
            'position'      =>  '',
            'color'         =>  'green'
        ),$atts));
        ob_start();
        $class = '';

        if( !empty($position) ){
            $class = 'noo-atributes-item'.$position;
        }
        if( $color != 'green' ){
            $class .= ' '.$color;
        }
        ?>
        <div class="noo-atributes-item <?php echo esc_attr($class); ?>">
            <div class="noo-atributes-hover">
                <div class="noo-atributes-content">
                    <?php if(isset($title) && !empty($title)): ?><a href="<?php echo esc_url($link); ?>"><strong><?php echo esc_html($title); ?></strong></a><?php endif; ?>
                    <?php if( isset($description) && !empty($description) ): ?><p><?php echo $description; ?></p><?php endif; ?>
                </div>
            </div>
            <span class="eff">
                <span class="eff1"></span>
                <span class="eff2"></span>
                <?php if( isset($icon) && !empty($icon) ):
                    echo wp_get_attachment_image(esc_attr($icon),'full');
                endif; ?>
            </span>
        </div>
        <?php
        $atributes = ob_get_contents();
        ob_end_clean();
        return $atributes;
    }
    add_shortcode('noo_atributes_item','noo_atributes_shortcode_item');