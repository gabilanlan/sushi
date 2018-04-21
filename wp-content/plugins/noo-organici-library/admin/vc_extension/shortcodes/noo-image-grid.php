<?php

    if( !function_exists('noo_shortcode_image_grid') ){

        function noo_shortcode_image_grid($atts){
            extract(shortcode_atts(array(
                'images'    =>  '',
                'rows'      =>  4,
            ),$atts));
            ob_start();

            ?>
            <div class="noo-images-grid">
                <ul>
                    <?php


                        $new_images = vc_param_group_parse_atts( $images );
                        if( isset($new_images) && !empty($new_images) ){
                            foreach( $new_images as $img_att ):
                                if( $img_att['image'] != '' && isset($img_att['image']) ):
                                $image = wp_get_attachment_image_src($img_att['image'],'full');
                                ?>
                                <li>
                                    <a href="<?php echo esc_attr($img_att['link']); ?>" <?php if( isset($image) && !empty($image) ): ?> style="background-image: url('<?php echo esc_url($image[0]) ?>')" <?php endif; ?>>
                                    </a>
                                </li>
                            <?php
                                endif;
                            endforeach;
                        }

                    ?>
                </ul>
            </div>
            <?php
            $images_grid = ob_get_contents();
            ob_end_clean();
            return $images_grid;
        }
        add_shortcode('noo_image_grid','noo_shortcode_image_grid');

    }