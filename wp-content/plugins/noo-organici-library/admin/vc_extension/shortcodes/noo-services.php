<?php

    if( !function_exists('noo_shortcode_services') ){

        function noo_shortcode_services($atts){
            extract(shortcode_atts(array(
                'icon'          =>      '',
                'attach'        =>      '',
                'title'         =>      '',
                'description'   =>      '',
                'services'       =>  ''
            ),$atts));
            ob_start();
            ?>
            <div class="inheader-sh-title services-sh-title">
                <?php if(isset( $icon ) && !empty( $icon )): echo wp_get_attachment_image( esc_attr($icon),'',false,array('class'=>'icon') ); endif;?>
                <?php if( isset($title) && !empty($title) ): ?><h2><?php echo esc_html($title); ?></h2><?php endif; ?>
                <?php if( isset($attach) && !empty($attach) ): ?><h4><?php echo esc_html($attach); ?></h4><?php endif; ?>
                <?php if( isset($description) && !empty($description) ): ?><p class="ds"><?php echo esc_html($description); ?></p><?php endif; ?>
            </div>
            <?php
            $new_services = vc_param_group_parse_atts( $services );
            if( isset($new_services) && !empty($new_services) ){
                echo '<ul class="noo-services-columns noo-row">';
                     foreach( $new_services as $service_item ){
                         ?>
                            <li class="noo-md-3 noo-sm-6">
                                <div class="noo-service-item">
                                    <span class="line-top">
                                        <span></span>
                                        <span></span>
                                    </span>
                                    <span class="line-left">
                                        <span></span>
                                        <span></span>
                                    </span>
                                    <div class="service-content">
                                        <h3><?php echo esc_html($service_item['title']); ?></h3>
                                        <a href="<?php echo $service_item['image_link']; ?>"><?php echo wp_get_attachment_image($service_item['image']); ?></a>
                                        <p><?php echo esc_html($service_item['description']); ?></p>
                                    </div>
                                </div>
                            </li>
                        <?php
                     }

                echo '</ul>';
            }

            $services = ob_get_contents();
            ob_end_clean();
            return $services;
        }
        add_shortcode('noo_services','noo_shortcode_services');

    }
