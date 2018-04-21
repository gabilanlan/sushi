<?php

    if( !function_exists('noo_shortcode_instagram') ){

        function noo_shortcode_instagram($atts){

            extract(shortcode_atts(array(
                'icon'                  =>      '',
                'attach'                =>      '',
                'title'                 =>      '',
                'description'           =>      '',
                'instagram_username'    =>  '',
                'number'                =>  10,
                'refresh_hour'          =>  4,
                'randomise'             =>  ''
            ),$atts));
            ob_start();
            wp_enqueue_script('vendor-imagesloaded');
            wp_enqueue_script('isotope');
            wp_enqueue_script('portfolio');
            $insta_url    = 'https://instagram.com/';
            $user_profile = $insta_url.$instagram_username;
            ?>
                <div class="noo-instagram">
                    <div class="noo-instagram-info">
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
                        <div class="noo-instagram-table">
                            <div class="inheader-sh-title instagram-sh-title">
                                <?php if(isset( $icon ) && !empty( $icon )): echo wp_get_attachment_image( esc_attr($icon),'',false,array('class'=>'icon') ); endif;?>
                                <?php if( isset($title) && !empty($title) ): ?><h2><?php echo esc_html($title); ?></h2><?php endif; ?>
                                <?php if( isset($attach) && !empty($attach) ): ?><h4><?php echo esc_html($attach); ?></h4><?php endif; ?>
                                <?php if( isset($description) && !empty($description) ): ?><p class="ds"><?php echo esc_html($description); ?></p><?php endif; ?>

                                <div class="on-instagram">
                                    <i class="fa fa-instagram"></i>
                                    <span>
                                        <?php echo esc_html__('follow us on instagram','noo-organici'); ?>
                                        <a href="<?php echo esc_url($user_profile) ?>">@<?php echo esc_html($instagram_username); ?></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="noo-instagram-image">
                        <div class="noo-product-grid">


                        <?php
                        $data = noo_organici_get_instagram_data( $instagram_username, $refresh_hour, $number, 'standard_resolution', $randomise );

                        if( isset($data) && is_array($data) && !empty($data)){
                            foreach ($data as $value) {

                                $link = '';
                                $image = '';
                                $text = '';
                                if( isset($value['link']) && !empty($value['link']) ){
                                    $link = $value['link'];
                                }
                                if( isset($value['text']) && !empty($value['text']) ){
                                    $text = $value['text'];
                                }
                                if( isset($value['image']) && !empty($value['image']) ){
                                    $image = $value['image'];
                                }
                                echo '<div class="noo-instagram-item masonry-item"><a target="_blank" href="'.esc_url($link).'"><img src="'.esc_url($image).'" alt="'.esc_attr($text).'"></a></div>';
                            }
                        }
                        ?>
                        </div>
                    </div>
                </div>
            <?php

            $instagram = ob_get_contents();
            ob_clean();
            return $instagram;

        }
        add_shortcode('noo_instagram','noo_shortcode_instagram');

    }