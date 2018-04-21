<?php

if( !function_exists('noo_shortcode_our_story2') ){
    function noo_shortcode_our_story2($atts,$content=null){
        extract(shortcode_atts(array(
            'title'            =>  '',
            'background'       =>  '',
            'signature'        =>  '',
            'name'             =>  '',
            'position'         =>  '',
            'image_bottom'     =>  ''
        ),$atts));
        ob_start();
            $image = wp_get_attachment_image_src($background,'full');
        ?>
            <div class="noo-our-story2">
               <div class="story-bk" style="background-image: url('<?php echo esc_url($image[0]) ; ?>')">
                   <?php if( isset($title) && !empty($title) ) ?><h2><?php echo esc_html($title);  ?></h2>
                   <div class="our_story_content">
                       <?php echo wpb_js_remove_wpautop($content, true); ?>
                   </div>
                   <div class="story-footer">
                       <?php if( isset($signature) && !empty($signature) ):
                           echo wp_get_attachment_image(esc_attr($signature),'full','',array('class'=>'signature'));
                       endif; ?>
                       <div class="name">
                           <?php if( isset($name) && !empty($name) ) ?><h6><?php echo esc_html($name);  ?></h6>
                           <?php if( isset($position) && !empty($position) ) ?><span><?php echo esc_html($position);  ?></span>
                       </div>
                   </div>
               </div>
                <?php if( isset($image_bottom) && !empty($image_bottom) ):
                    echo wp_get_attachment_image(esc_attr($image_bottom),'full','',array('class'=>'image-bottom'));
                endif; ?>
            </div>
        <?php
        $story = ob_get_contents();
        ob_end_clean();
        return $story;
    }
    add_shortcode('noo_our_story2','noo_shortcode_our_story2');
}