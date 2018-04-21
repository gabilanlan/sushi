<?php

    if( !function_exists('noo_shortcode_our_story') ){
        function noo_shortcode_our_story($atts,$content=null){
            extract(shortcode_atts(array(
                'title'         =>  '',
                'signature'     =>  '',
                'button_name'   =>  '',
                'button_link'   =>  '',
                'galley'        =>  ''
            ),$atts));
            ob_start();
            wp_enqueue_script('vendor-modernizr-custom');
            wp_enqueue_script('vendor-draggabilly');
            wp_enqueue_script('vendor-elastiStack');
            $id_el = uniqid('elasticstack-');
            ?>
                <div class="noo-row noo-our_story">
                    <div class="noo-md-6 noo-sm-6">
                        <?php if( isset($title) && !empty($title) ) ?><h2><?php echo esc_html($title);  ?></h2>
                        <div class="our_story_content">
                            <?php echo wpb_js_remove_wpautop($content, true); ?>
                        </div>
                        <?php if( isset($signature) && !empty($signature) ):
                            echo wp_get_attachment_image(esc_attr($signature),'full','',array('class'=>'signature'));
                        endif; ?>
                        <?php if( isset( $button_name ) && !empty($button_name) ): ?>
                            <p class="text-center">
                                <a href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_name) ?></a>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="noo-md-6 noo-sm-6">
                        <ul id="<?php echo esc_attr($id_el); ?>" class="elasticstack">
                            <?php if( isset($galley) && !empty($galley) ):
                                    $new_id = explode(',',$galley);
                                    foreach($new_id as $id):
                                        $att_img = wp_get_attachment_image_src($id,'full');
                                     echo '<li><div class="image-elastickstack" style="background-image: url('.esc_url($att_img[0]).')"></div></li>';
                            endforeach; endif; ?>
                        </ul>

                    </div>
                </div>
            <script>
                jQuery(document).ready(function(){
                    new ElastiStack( document.getElementById( '<?php echo esc_attr($id_el); ?>' ) );
                })
            </script>
            <?php
            $story = ob_get_contents();
            ob_end_clean();
            return $story;
        }
        add_shortcode('noo_our_story','noo_shortcode_our_story');
    }